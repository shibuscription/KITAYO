<?php
/**
 * @var int $scanLogId
 * @var \App\Model\Entity\ScanLog $scanLog
 * @var string $idm
 * @var array $employeeList
 */
?>
<style>
  :root{
    --bg:#0b1220;
    --card:#111a2e;
    --text:#eaf0ff;
    --muted:rgba(234,240,255,.78);
    --border:rgba(255,255,255,.12);
    --accent1:#60a5fa;
    --accent2:#22c55e;
  }
  body{ margin:0; min-height:100vh; background:var(--bg); color:var(--text); }
  .wrap{ min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; }
  .panel{
    width:min(900px,100%);
    border:1px solid var(--border);
    background: rgba(17,26,46,.60);
    border-radius: 22px;
    padding: 22px;
    box-shadow: 0 20px 50px rgba(0,0,0,.35);
  }
  h1{ margin:0 0 8px; font-size:26px; }
  .sub{ margin:0 0 14px; color:var(--muted); font-size:14px; }
  .idm{
    font-variant-numeric: tabular-nums;
    border:1px solid var(--border);
    border-radius: 16px;
    padding: 12px 14px;
    background: rgba(0,0,0,.18);
    margin: 12px 0 16px;
  }
  .row{ display:grid; gap:10px; }
  select{
    width:100%;
    font-size:22px;
    padding: 14px 12px;
    border-radius: 16px;
    border:1px solid var(--border);
    background: rgba(0,0,0,.25);
    color: var(--text);
  }
  .btn{
    width:100%;
    margin-top: 10px;
    font-size: 26px;
    font-weight: 900;
    padding: 18px 16px;
    border:none;
    border-radius: 18px;
    cursor:pointer;
    color:#0b1220;
    background: linear-gradient(135deg, var(--accent1), var(--accent2));
    box-shadow: 0 16px 40px rgba(0,0,0,.35);
  }
  .hint{ margin-top:12px; color:var(--muted); font-size:13px; }
</style>

<div class="wrap">
  <div class="panel">
    <h1>このカードは未登録です</h1>
    <p class="sub">どの社員のカードかを選んで、ここで紐づけできます。</p>

    <div class="idm">
      <div style="opacity:.8; font-size:12px;">IDM</div>
      <div style="font-size:20px; font-weight:800; letter-spacing:.5px;"><?= h($idm) ?></div>
      <div style="opacity:.75; font-size:12px; margin-top:6px;">
        device: <?= h((string)$scanLog->device_id) ?> / scanned_at: <?= h((string)$scanLog->scanned_at) ?>
      </div>
    </div>

    <?= $this->Form->create(null) ?>
      <?= $this->Form->control('employee_id', [
        'type' => 'select',
        'label' => false,
        'options' => $employeeList,
        'empty' => '社員を選択してください',
      ]) ?>

      <button class="btn" type="submit">この社員に紐づけて続行</button>
    <?= $this->Form->end() ?>

    <p class="hint">
      ※ いまは全員一覧です（後で「会社で絞り込み」「検索」「QR/社員番号入力」など改善できます）
    </p>
  </div>
</div>
