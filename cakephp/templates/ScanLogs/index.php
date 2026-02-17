<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ScanLog> $scanLogs
 */
?>
<div class="scanLogs index content">
    <?= $this->Html->link(__('New Scan Log'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Scan Logs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('idm') ?></th>
                    <th><?= $this->Paginator->sort('device_id') ?></th>
                    <th><?= $this->Paginator->sort('scanned_at') ?></th>
                    <th><?= $this->Paginator->sort('processed') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scanLogs as $scanLog): ?>
                <tr>
                    <td><?= $this->Number->format($scanLog->id) ?></td>
                    <td><?= h($scanLog->idm) ?></td>
                    <td><?= $scanLog->has('device') ? $this->Html->link($scanLog->device->device_id, ['controller' => 'Devices', 'action' => 'view', $scanLog->device->id]) : '' ?></td>
                    <td><?= h($scanLog->scanned_at) ?></td>
                    <td><?= h($scanLog->processed) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $scanLog->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $scanLog->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $scanLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scanLog->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
