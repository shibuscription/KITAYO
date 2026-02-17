<?php

/**
 * @var \App\Model\Entity\ScanLog $scanLog
 * @var \App\Model\Entity\AttendanceRecord|null $record
 * @var bool $canCheckIn
 * @var bool $canCheckOut
 * @var int $employeeId
 */

// 画面表示用（チェックイン/アウト時刻）
$checkInText  = ($record && $record->check_in)  ? $record->check_in->i18nFormat('HH:mm:ss') : '--:--:--';
$checkOutText = ($record && $record->check_out) ? $record->check_out->i18nFormat('HH:mm:ss') : '--:--:--';

// 戻り先（Dashboardに戻す）
$cancelUrl = $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']);
?>
<style>
    :root {
        --bg: #0b1220;
        --card: #111a2e;
        --text: #eaf0ff;
        --muted: rgba(234, 240, 255, .75);
        --border: rgba(255, 255, 255, .12);

        --in1: #2dd4bf;
        /* 出勤：ティール */
        --in2: #22c55e;
        /* 出勤：グリーン寄り */
        --out1: #fb7185;
        /* 退勤：ピンク */
        --out2: #f97316;
        /* 退勤：オレンジ */
        --disabled: rgba(255, 255, 255, .18);
    }

    body {
        background: radial-gradient(1200px 700px at 20% 0%, rgba(45, 212, 191, .18), transparent 60%),
            radial-gradient(1200px 700px at 80% 0%, rgba(249, 115, 22, .16), transparent 60%),
            var(--bg);
        color: var(--text);
    }

    .wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 18px 18px 22px;
    }

    .top {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        border: 1px solid var(--border);
        background: rgba(17, 26, 46, .55);
        border-radius: 16px;
        backdrop-filter: blur(6px);
    }

    .greet {
        line-height: 1.2;
    }

    .greet .name {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
    }

    .greet .sub {
        margin: 6px 0 0;
        color: var(--muted);
        font-size: 13px;
    }

    .clock {
        user-select: none;
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
        gap: 12px;
    }

    .clockInner {
        text-align: right;
    }

    /* ★キャンセルボタン */
    .cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: rgba(234, 240, 255, .85);
        text-decoration: none;
        padding: 6px 10px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, .14);
        background: rgba(17, 26, 46, .35);
        transition: filter .12s ease, transform .08s ease, background .12s ease;
        margin-top: 2px;
    }

    .cancel:hover {
        filter: brightness(1.08);
        background: rgba(17, 26, 46, .55);
    }

    .cancel:active {
        transform: translateY(1px);
    }

    .clock .time {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: .8px;
        font-variant-numeric: tabular-nums;
        margin: 0;
    }

    .clock .date {
        margin: 4px 0 0;
        color: var(--muted);
        font-size: 12px;
    }

    .buttons {
        margin-top: 16px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .btn {
        appearance: none;
        border: none;
        width: 100%;
        min-height: 56vh;
        /* ★でかさの肝：画面の大部分を占める */
        border-radius: 22px;
        color: #0b1220;
        font-weight: 900;
        font-size: 54px;
        /* ★タブレットで押しやすい */
        letter-spacing: 1px;
        cursor: pointer;
        box-shadow:
            0 16px 40px rgba(0, 0, 0, .35),
            inset 0 0 0 1px rgba(255, 255, 255, .18);
        transition: transform .08s ease, filter .12s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn:active {
        transform: translateY(2px) scale(.995);
    }

    .btn:hover {
        filter: brightness(1.03);
    }

    .btn-in {
        background: linear-gradient(135deg, var(--in1), var(--in2));
    }

    .btn-out {
        background: linear-gradient(135deg, var(--out1), var(--out2));
    }

    .btn[disabled] {
        cursor: not-allowed;
        background: var(--disabled);
        color: rgba(234, 240, 255, .55);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .10);
    }

    .footer {
        margin-top: 14px;
        display: flex;
        justify-content: space-between;
        gap: 10px;
        color: var(--muted);
        font-size: 13px;
    }

    .pill {
        border: 1px solid var(--border);
        background: rgba(17, 26, 46, .55);
        border-radius: 999px;
        padding: 8px 12px;
    }

    /* スマホ縦は縦積みに */
    @media (max-width: 720px) {
        .buttons {
            grid-template-columns: 1fr;
        }

        .btn {
            min-height: 28vh;
            font-size: 44px;
        }

        .top {
            align-items: flex-start;
        }

        .clock {
            gap: 10px;
        }
    }
</style>

<div class="wrap">
    <div class="top">
        <div class="greet">
            <p class="name"><?= h($employeeName) ?> さん　お疲れ様です</p>
            <p class="sub">カードを読み取りました。押したいボタンを選んでください。</p>
        </div>

        <div class="clock">
            <!-- ★ここにキャンセル -->
            <a class="cancel" href="<?= h($cancelUrl) ?>">← キャンセル</a>

            <div class="clockInner">
                <p id="clockTime" class="time">--:--:--</p>
                <p id="clockDate" class="date">----</p>
            </div>
        </div>
    </div>

    <div class="buttons">
        <!-- 出勤 -->
        <?= $this->Form->create(null, ['url' => ['controller' => 'Attendance', 'action' => 'commit']]) ?>
        <?= $this->Form->hidden('scan_log_id', ['value' => $scanLog->id]) ?>
        <?= $this->Form->hidden('action', ['value' => 'check_in']) ?>
        <button class="btn btn-in" type="submit" <?= $canCheckIn ? '' : 'disabled' ?>>
            出勤
        </button>
        <?= $this->Form->end() ?>

        <!-- 退勤 -->
        <?= $this->Form->create(null, ['url' => ['controller' => 'Attendance', 'action' => 'commit']]) ?>
        <?= $this->Form->hidden('scan_log_id', ['value' => $scanLog->id]) ?>
        <?= $this->Form->hidden('action', ['value' => 'check_out']) ?>
        <button class="btn btn-out" type="submit" <?= $canCheckOut ? '' : 'disabled' ?>>
            退勤
        </button>
        <?= $this->Form->end() ?>
    </div>

    <div class="footer">
        <div class="pill">出勤：<?= h($checkInText) ?></div>
        <div class="pill">退勤：<?= h($checkOutText) ?></div>
    </div>
</div>

<script>
    /** ===== Clock ===== **/
    const timeEl = document.getElementById('clockTime');
    const dateEl = document.getElementById('clockDate');

    function pad2(n) {
        return String(n).padStart(2, '0');
    }

    function renderClock() {
        const d = new Date();
        const hh = pad2(d.getHours());
        const mm = pad2(d.getMinutes());
        const ss = pad2(d.getSeconds());
        timeEl.textContent = `${hh}:${mm}:${ss}`;

        const y = d.getFullYear();
        const m = pad2(d.getMonth() + 1);
        const day = pad2(d.getDate());
        const w = ['日', '月', '火', '水', '木', '金', '土'][d.getDay()];
        dateEl.textContent = `${y}/${m}/${day}（${w}）`;
    }

    function startClock() {
        renderClock();
        const now = new Date();
        const msToNextSecond = 1000 - now.getMilliseconds();
        setTimeout(() => {
            renderClock();
            setInterval(renderClock, 1000);
        }, msToNextSecond);
    }
    startClock();
</script>
