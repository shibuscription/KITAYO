<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;

class AttendanceController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('kiosk');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['decide', 'commit', 'complete']);
    }


    private function resolveEmployeeIdByIdmOrNull(string $idm): ?int
    {
        $employeeIdm = $this->fetchTable('EmployeeIdm');

        $row = $employeeIdm->find()
            ->where(['idm' => $idm, 'active_flag' => 1])
            ->first();

        return $row ? (int)$row->employee_id : null;
    }


    public function decide()
    {
        $scanLogId = (int)$this->request->getQuery('scan_log_id');

        $scanLogs  = $this->fetchTable('ScanLogs');
        $records   = $this->fetchTable('AttendanceRecords');
        $employees = $this->fetchTable('Employees');

        $deviceId = (string)$this->request->getSession()->read('Kiosk.device_id');
        if ($deviceId === '') {
            $this->Flash->error('Device is not set. Please setup kiosk device.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        $scanLog = $scanLogs->get($scanLogId);
        if ((string)$scanLog->device_id !== $deviceId) {
            $this->Flash->error('Device mismatch for scan log.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        if ((string)$scanLog->device_id !== $deviceId) {
            $this->Flash->error('Device mismatch for scan log.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        $idm = (string)$scanLog->idm;
        $employeeId = $this->resolveEmployeeIdByIdmOrNull($idm);

        if ($employeeId === null) {
            return $this->redirect([
                'controller' => 'EmployeeIdm',
                'action' => 'register',
                '?' => ['scan_log_id' => $scanLogId],
            ]);
        }

        $employee = $employees->find()
            ->select(['id', 'employee_name'])
            ->where(['id' => $employeeId])
            ->first();

        $employeeName = $employee ? $employee->employee_name : '（不明）';

        $scannedAt = FrozenTime::parse($scanLog->scanned_at);
        $workDate  = $scannedAt->toDateString();

        $record = $records->find()
            ->where(['employee_id' => $employeeId, 'work_date' => $workDate])
            ->first();

        $canCheckIn  = !$record || $record->check_in === null;
        $canCheckOut = $record && $record->check_in !== null && $record->check_out === null;

        $this->set(compact(
            'scanLog',
            'employeeId',
            'employeeName',
            'record',
            'workDate',
            'canCheckIn',
            'canCheckOut'
        ));
    }


    public function commit()
    {
        $this->request->allowMethod(['post']);

        $scanLogId = (int)$this->request->getData('scan_log_id');
        $action    = (string)$this->request->getData('action'); // check_in / check_out

        if (!in_array($action, ['check_in', 'check_out'], true)) {
            throw new \InvalidArgumentException('invalid action');
        }

        $scanLogs = $this->fetchTable('ScanLogs');
        $records  = $this->fetchTable('AttendanceRecords');

        $deviceId = (string)$this->request->getSession()->read('Kiosk.device_id');
        if ($deviceId === '') {
            $this->Flash->error('Device is not set. Please setup kiosk device.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        $deviceId = (string)$this->request->getSession()->read('Kiosk.device_id');
        if ($deviceId === '') {
            $this->Flash->error('Device is not set. Please setup kiosk device.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        // ★シンプル運用：processed 条件は付けない（next が 1 にしててもOK）
        $scanLog = $scanLogs->get($scanLogId);
        if ((string)$scanLog->device_id !== $deviceId) {
            $this->Flash->error('Device mismatch for scan log.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        $employeeId = $this->resolveEmployeeIdByIdmOrNull((string)$scanLog->idm);

        $scannedAt = FrozenTime::parse($scanLog->scanned_at);
        $workDate  = $scannedAt->toDateString();

        // ★トランザクションは records だけでOK（scan_logs は触らない）
        $records->getConnection()->transactional(function () use ($records, $employeeId, $workDate, $scannedAt, $action) {

            $record = $records->find()
                ->where(['employee_id' => $employeeId, 'work_date' => $workDate])
                ->first();

            if (!$record) {
                $record = $records->newEmptyEntity();
                $record->employee_id = $employeeId;
                $record->work_date   = $workDate;
            }

            if ($action === 'check_in') {
                if ($record->check_in !== null) {
                    throw new \RuntimeException('already checked in');
                }
                $record->check_in = $scannedAt;
            }

            if ($action === 'check_out') {
                if ($record->check_in === null) {
                    throw new \RuntimeException('not checked in yet');
                }
                if ($record->check_out !== null) {
                    throw new \RuntimeException('already checked out');
                }
                $record->check_out = $scannedAt;
            }

            $records->saveOrFail($record);
        });

        return $this->redirect([
            'controller' => 'Attendance',
            'action' => 'complete',
            '?' => [
                'message' => ($action === 'check_in')
                    ? '出勤を記録しました'
                    : '退勤を記録しました',
            ]
        ]);
    }

    public function complete()
    {
        $message = (string)$this->request->getQuery('message', '記録しました');
        $this->set(compact('message'));
    }
}
