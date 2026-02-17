<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Device> $devices
 */
?>
<div class="devices index content">
    <?= $this->Html->link(__('New Device'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Devices') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('device_id') ?></th>
                    <th><?= $this->Paginator->sort('device_name') ?></th>
                    <th><?= $this->Paginator->sort('location') ?></th>
                    <th><?= $this->Paginator->sort('active_flag') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($devices as $device): ?>
                <tr>
                    <td><?= $this->Number->format($device->id) ?></td>
                    <td><?= $device->has('company') ? $this->Html->link($device->company->company_name, ['controller' => 'Companies', 'action' => 'view', $device->company->id]) : '' ?></td>
                    <td><?= h($device->device_id) ?></td>
                    <td><?= h($device->device_name) ?></td>
                    <td><?= h($device->location) ?></td>
                    <td><?= h($device->active_flag) ?></td>
                    <td><?= h($device->created) ?></td>
                    <td><?= h($device->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $device->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $device->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $device->id], ['confirm' => __('Are you sure you want to delete # {0}?', $device->id)]) ?>
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
