<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;

class TimecardsController extends AppController
{
    public function index()
    {
        // employee ログイン前提
        $identity = $this->request->getAttribute('identity');
        $employeeId = $identity ? (int)$identity->get('employee_id') : 0;

        if ($employeeId <= 0) {
            $this->Flash->error('従業員としてログインしてください。');
            return $this->redirect('/login');
        }

        // 表示する年月（month=YYYY-MM）
        $monthParam = (string)$this->request->getQuery('month', '');
        if (preg_match('/^\d{4}-\d{2}$/', $monthParam)) {
            [$y, $m] = array_map('intval', explode('-', $monthParam));
            $firstDay = FrozenDate::create($y, $m, 1);
        } else {
            $today = FrozenDate::today();
            $firstDay = FrozenDate::create(
                (int)$today->format('Y'),
                (int)$today->format('m'),
                1
            );
        }

        $lastDay   = $firstDay->endOfMonth();
        $prevMonth = $firstDay->subMonths(1)->format('Y-m');
        $nextMonth = $firstDay->addMonths(1)->format('Y-m');

        // 勤怠レコード取得（キー＝日付）
        $records = $this->fetchTable('AttendanceRecords')->find()
            ->where([
                'employee_id'   => $employeeId,
                'work_date >='  => $firstDay,
                'work_date <='  => $lastDay,
            ])
            ->orderAsc('work_date')
            ->all()
            ->indexBy(function ($row) {
                return $row->work_date->format('Y-m-d');
            })
            ->toArray();

        // 1日1行生成
        $rows = [];
        $totalWorkMinutes = 0;

        for ($d = $firstDay; $d <= $lastDay; $d = $d->addDays(1)) {
            $key = $d->format('Y-m-d');
            $rec = $records[$key] ?? null;

            $workMinutes = 0;

            if ($rec && $rec->check_in && $rec->check_out) {

                // 秒を 00 に正規化（分単位の世界に揃える）
                $in = $rec->check_in
                    ->setTime(
                        (int)$rec->check_in->format('H'),
                        (int)$rec->check_in->format('i'),
                        0
                    );

                $out = $rec->check_out
                    ->setTime(
                        (int)$rec->check_out->format('H'),
                        (int)$rec->check_out->format('i'),
                        0
                    );

                // まず出退勤差分（分）
                $workMinutes = intdiv($out->getTimestamp() - $in->getTimestamp(), 60);

                // 休憩差し引き（休憩も秒00に揃える）
                if ($rec->break_start && $rec->break_end) {
                    $bs = $rec->break_start
                        ->setTime(
                            (int)$rec->break_start->format('H'),
                            (int)$rec->break_start->format('i'),
                            0
                        );

                    $be = $rec->break_end
                        ->setTime(
                            (int)$rec->break_end->format('H'),
                            (int)$rec->break_end->format('i'),
                            0
                        );

                    $breakMinutes = intdiv($be->getTimestamp() - $bs->getTimestamp(), 60);
                    if ($breakMinutes > 0) {
                        $workMinutes -= $breakMinutes;
                    }
                }

                if ($workMinutes < 0) {
                    $workMinutes = 0;
                }
            }


            $totalWorkMinutes += $workMinutes;

            $rows[] = [
                'date'        => $d,
                'record'      => $rec,
                'workMinutes' => $workMinutes,
            ];
        }

        // 合計を表示用に分解
        $totalHours        = intdiv($totalWorkMinutes, 60);
        $totalRemainMinute = $totalWorkMinutes % 60;

        $this->set(compact(
            'firstDay',
            'prevMonth',
            'nextMonth',
            'rows',
            'totalWorkMinutes',
            'totalHours',
            'totalRemainMinute'
        ));
    }

    // ※ 表示専用。編集系は後回しでOK
}
