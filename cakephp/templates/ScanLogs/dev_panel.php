<?php
// debug=true の時しか到達しない想定
?>
<h1>Dev Panel（ScanLogs）</h1>

<p>テスト用ScanLogを投入します。</p>

<div style="display:flex; gap:12px; flex-wrap:wrap; margin: 12px 0;">
  <!-- よく使うやつ：ワンクリック投入 -->
  <button type="button" onclick="location.href='/scan-logs/dev-create'">
    1件投入（デフォルト）
  </button>

  <button type="button" onclick="location.href='/scan-logs/dev-create?idm=TEST_IDM_001&device_id=DEV_LOCAL'">
    TEST_IDM_001 / DEV_LOCAL
  </button>

  <button type="button" onclick="location.href='/scan-logs/dev-create?idm=TEST_IDM_002&device_id=DEV_LOCAL'">
    TEST_IDM_002 / DEV_LOCAL
  </button>

  <button type="button" onclick="location.href='/scan-logs/dev-create?idm=TEST_IDM_003&device_id=DEV_LOCAL'">
    TEST_IDM_003 / DEV_LOCAL
  </button>
</div>

<hr>

<h2>自由入力</h2>

<form method="get" action="/scan-logs/dev-create" style="display:grid; gap:8px; max-width:420px;">
  <label>
    idm
    <input name="idm" value="<?= h($defaultIdm) ?>" />
  </label>

  <label>
    device_id
    <input name="device_id" value="<?= h($defaultDeviceId) ?>" />
  </label>

  <label>
    at（任意: yyyy-mm-dd HH:MM:SS）
    <input name="at" placeholder="例: 2026-01-22 12:34:56" />
  </label>

  <button type="submit">この内容で投入</button>
</form>

<p style="margin-top:16px;">
  <a href="/dashboard">Dashboardへ戻る</a>
</p>
