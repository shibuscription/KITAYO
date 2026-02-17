<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeIdm $employeeIdm
 * @var \Cake\Collection\CollectionInterface|string[] $employees
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Employee Idm'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="employeeIdm form content">
            <?= $this->Form->create($employeeIdm) ?>
            <fieldset>
                <legend><?= __('Add Employee Idm') ?></legend>
                <?php
                    echo $this->Form->control('employee_id', ['options' => $employees]);
                    echo $this->Form->control('idm');
                    echo $this->Form->control('active_flag');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
