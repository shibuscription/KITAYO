<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ScanLog $scanLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Scan Log'), ['action' => 'edit', $scanLog->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Scan Log'), ['action' => 'delete', $scanLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scanLog->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Scan Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Scan Log'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="scanLogs view content">
            <h3><?= h($scanLog->idm) ?></h3>
            <table>
                <tr>
                    <th><?= __('Idm') ?></th>
                    <td><?= h($scanLog->idm) ?></td>
                </tr>
                <tr>
                    <th><?= __('Device') ?></th>
                    <td><?= $scanLog->has('device') ? $this->Html->link($scanLog->device->device_id, ['controller' => 'Devices', 'action' => 'view', $scanLog->device->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($scanLog->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Scanned At') ?></th>
                    <td><?= h($scanLog->scanned_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Processed') ?></th>
                    <td><?= $scanLog->processed ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
