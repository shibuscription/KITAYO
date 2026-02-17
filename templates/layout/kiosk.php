<?php
/**
 * kiosk layout: ヘッダー/メニュー無し（打刻端末用）
 */
?>
<!doctype html>
<html lang="ja">
<head>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title><?= h($this->fetch('title') ?: 'Kintai') ?></title>
  <?= $this->Html->meta('icon') ?>
  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
</head>
<body>
  <?= $this->fetch('content') ?>
  <?= $this->fetch('script') ?>
</body>
</html>
