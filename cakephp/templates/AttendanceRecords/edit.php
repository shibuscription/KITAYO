<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AttendanceRecord $attendanceRecord
 * @var string[]|\Cake\Collection\CollectionInterface $employees
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $attendanceRecord->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $attendanceRecord->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Attendance Records'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="attendanceRecords form content">
            <?= $this->Form->create($attendanceRecord) ?>
            <fieldset>
                <legend><?= __('Edit Attendance Record') ?></legend>
                <?php
                    echo $this->Form->control('employee_id', ['options' => $employees]);
                    echo $this->Form->control('work_date');
                    echo $this->Form->control('check_in', ['empty' => true]);
                    echo $this->Form->control('check_out', ['empty' => true]);
                    echo $this->Form->control('break_start', ['empty' => true]);
                    echo $this->Form->control('break_end', ['empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('note');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
