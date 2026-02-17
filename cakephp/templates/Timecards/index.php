<?php

/**
 * @var \Cake\I18n\FrozenDate $firstDay
 * @var string $prevMonth
 * @var string $nextMonth
 * @var array $rows
 */
function fmtTime($dt): string
{
    if (!$dt) return '';
    // datetime を "HH:MM" 表示
    return $dt->format('H:i');
}

function fmtHMFromMinutes(int $min): string
{
    $h = intdiv($min, 60);
    $m = $min % 60;
    return sprintf('%d:%02d', $h, $m);
}

?>

<style>
    .row-today {
        background: rgb(245, 247, 250); /* #f5f7fa */
    }

    /* 今日：薄いハイライト */
    .row-sat {
        background: rgba(59, 130, 246, .10);
    }

    /* 土：薄い青 */
    .row-sun {
        background: rgba(239, 68, 68, .10);
    }

    /* 日：薄い赤 */

    /* 今日が土日の場合は少しだけ重ねる（好みで） */
    .row-today.row-sat {
        background: rgba(59, 130, 246, .14);
    }

    .row-today.row-sun {
        background: rgba(239, 68, 68, .14);
    }

    .total-box {
        margin-top: 14px;
        padding: 12px 14px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #fafafa;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .total-box .label {
        color: #666;
    }

    .total-box .value {
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }
</style>


<div style="max-width:920px;margin:24px auto;padding:0 16px;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;">
        <a href="/timecards?month=<?= h($prevMonth) ?>" style="text-decoration:none;">← 前月</a>

        <h1 style="margin:0;"><?= h($firstDay->format('Y年n月')) ?> タイムカード</h1>

        <a href="/timecards?month=<?= h($nextMonth) ?>" style="text-decoration:none;">次月 →</a>
    </div>

    <div style="margin-top:16px;border:1px solid #ddd;border-radius:10px;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f6f6f6;">
                    <th style="text-align:left;padding:10px;border-bottom:1px solid #ddd;width:140px;">日付</th>
                    <th style="text-align:left;padding:10px;border-bottom:1px solid #ddd;">出勤</th>
                    <th style="text-align:left;padding:10px;border-bottom:1px solid #ddd;">退勤</th>
                    <th style="text-align:left;padding:10px;border-bottom:1px solid #ddd;">休憩</th>
                    <th style="text-align:left;padding:10px;border-bottom:1px solid #ddd;">勤務時間</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                    <?php
                    $d = $r['date'];
                    $rec = $r['record'];

                    $isToday = $d->format('Y-m-d') === \Cake\I18n\FrozenDate::today()->format('Y-m-d');
                    $dow = (int)$d->format('w'); // 0=日, 6=土
                    $classes = [];
                    if ($isToday) $classes[] = 'row-today';
                    if ($dow === 6) $classes[] = 'row-sat';
                    if ($dow === 0) $classes[] = 'row-sun';
                    ?>
                    <tr class="<?= h(implode(' ', $classes)) ?>">
                        <td style="padding:10px;border-bottom:1px solid #eee;">
                            <?= h($d->format('n/j')) ?>
                            <span style="color:#888;"><?= h($d->format('(D)')) ?></span>
                        </td>

                        <td style="padding:10px;border-bottom:1px solid #eee;">
                            <?= h(fmtTime($rec?->check_in)) ?>
                        </td>

                        <td style="padding:10px;border-bottom:1px solid #eee;">
                            <?= h(fmtTime($rec?->check_out)) ?>
                        </td>

                        <td style="padding:10px;border-bottom:1px solid #eee;">
                            <?php if ($rec && ($rec->break_start || $rec->break_end)): ?>
                                <?= h(fmtTime($rec->break_start)) ?> - <?= h(fmtTime($rec->break_end)) ?>
                            <?php endif; ?>
                        </td>

                        <td style="padding:10px;border-bottom:1px solid #eee;">
                            <?= fmtHMFromMinutes($r['workMinutes']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="total-box">
        <div class="label">月合計（勤務時間）</div>
        <div class="value"><?= h(fmtHMFromMinutes((int)$totalWorkMinutes)) ?></div>
    </div>

</div>
