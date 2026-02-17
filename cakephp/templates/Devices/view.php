<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Device $device
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Device'), ['action' => 'edit', $device->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Device'), ['action' => 'delete', $device->id], ['confirm' => __('Are you sure you want to delete # {0}?', $device->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Devices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Device'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="devices view content">
            <h3><?= h($device->device_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $device->has('company') ? $this->Html->link($device->company->company_name, ['controller' => 'Companies', 'action' => 'view', $device->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Device Id') ?></th>
                    <td><?= h($device->device_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Device Name') ?></th>
                    <td><?= h($device->device_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= h($device->location) ?></td>
                </tr>
                <tr>
                    <th><?= __('Device') ?></th>
                    <td><?= $device->has('device') ? $this->Html->link($device->device->device_id, ['controller' => 'Devices', 'action' => 'view', $device->device->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($device->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($device->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($device->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active Flag') ?></th>
                    <td><?= $device->active_flag ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Scan Logs') ?></h4>
                <?php if (!empty($device->scan_logs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Idm') ?></th>
                            <th><?= __('Device Id') ?></th>
                            <th><?= __('Scanned At') ?></th>
                            <th><?= __('Processed') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($device->scan_logs as $scanLogs) : ?>
                        <tr>
                            <td><?= h($scanLogs->id) ?></td>
                            <td><?= h($scanLogs->idm) ?></td>
                            <td><?= h($scanLogs->device_id) ?></td>
                            <td><?= h($scanLogs->scanned_at) ?></td>
                            <td><?= h($scanLogs->processed) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ScanLogs', 'action' => 'view', $scanLogs->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ScanLogs', 'action' => 'edit', $scanLogs->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ScanLogs', 'action' => 'delete', $scanLogs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scanLogs->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
