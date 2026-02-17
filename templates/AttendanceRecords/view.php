<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AttendanceRecord $attendanceRecord
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Attendance Record'), ['action' => 'edit', $attendanceRecord->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Attendance Record'), ['action' => 'delete', $attendanceRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attendanceRecord->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Attendance Records'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Attendance Record'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="attendanceRecords view content">
            <h3><?= h($attendanceRecord->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Employee') ?></th>
                    <td><?= $attendanceRecord->has('employee') ? $this->Html->link($attendanceRecord->employee->employee_name, ['controller' => 'Employees', 'action' => 'view', $attendanceRecord->employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($attendanceRecord->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($attendanceRecord->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Work Date') ?></th>
                    <td><?= h($attendanceRecord->work_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Check In') ?></th>
                    <td><?= h($attendanceRecord->check_in) ?></td>
                </tr>
                <tr>
                    <th><?= __('Check Out') ?></th>
                    <td><?= h($attendanceRecord->check_out) ?></td>
                </tr>
                <tr>
                    <th><?= __('Break Start') ?></th>
                    <td><?= h($attendanceRecord->break_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Break End') ?></th>
                    <td><?= h($attendanceRecord->break_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($attendanceRecord->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($attendanceRecord->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Note') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($attendanceRecord->note)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
