<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AttendanceRecord> $attendanceRecords
 */
?>
<div class="attendanceRecords index content">
    <?= $this->Html->link(__('New Attendance Record'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Attendance Records') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('employee_id') ?></th>
                    <th><?= $this->Paginator->sort('work_date') ?></th>
                    <th><?= $this->Paginator->sort('check_in') ?></th>
                    <th><?= $this->Paginator->sort('check_out') ?></th>
                    <th><?= $this->Paginator->sort('break_start') ?></th>
                    <th><?= $this->Paginator->sort('break_end') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendanceRecords as $attendanceRecord): ?>
                <tr>
                    <td><?= $this->Number->format($attendanceRecord->id) ?></td>
                    <td><?= $attendanceRecord->has('employee') ? $this->Html->link($attendanceRecord->employee->employee_name, ['controller' => 'Employees', 'action' => 'view', $attendanceRecord->employee->id]) : '' ?></td>
                    <td><?= h($attendanceRecord->work_date) ?></td>
                    <td><?= h($attendanceRecord->check_in) ?></td>
                    <td><?= h($attendanceRecord->check_out) ?></td>
                    <td><?= h($attendanceRecord->break_start) ?></td>
                    <td><?= h($attendanceRecord->break_end) ?></td>
                    <td><?= h($attendanceRecord->status) ?></td>
                    <td><?= h($attendanceRecord->created) ?></td>
                    <td><?= h($attendanceRecord->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $attendanceRecord->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $attendanceRecord->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $attendanceRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attendanceRecord->id)]) ?>
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
