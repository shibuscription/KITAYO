<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <title><?= $this->fetch('title') ?> | 勤怠システム</title>
    <?= $this->Html->meta('viewport', 'width=device-width, initial-scale=1') ?>
    <?= $this->Html->css('style') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
    <header>
        <button id="menuToggle">☰</button>
        <h1>勤怠管理システム</h1>
    </header>

    <nav id="sideMenu">
        <ul>
            <li><?= $this->Html->link('会社一覧', ['controller' => 'Companies', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('社員一覧', ['controller' => 'Employees', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('端末一覧', ['controller' => 'Devices', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('IDm紐付け', ['controller' => 'EmployeeIdm', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('ユーザー一覧', ['controller' => 'Users', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('スキャンログ', ['controller' => 'ScanLogs', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('勤怠記録', ['controller' => 'AttendanceRecords', 'action' => 'index']) ?></li>

            <li class="menu-divider"></li>

            <li>
                <?= $this->Form->create(null, [
                    'url' => ['controller' => 'Users', 'action' => 'logout'],
                    'style' => 'margin:0;',
                ]) ?>
                <button type="submit" class="menu-logout">
                    ログアウト
                </button>
                <?= $this->Form->end() ?>
            </li>
        </ul>
    </nav>

    <main>
        <?= $this->fetch('content') ?>
    </main>

    <script>
        const toggle = document.getElementById('menuToggle');
        const menu = document.getElementById('sideMenu');
        toggle.addEventListener('click', () => {
            menu.classList.toggle('open');
        });
    </script>
</body>

</html>
