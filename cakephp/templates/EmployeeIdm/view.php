<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeIdm $employeeIdm
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Employee Idm'), ['action' => 'edit', $employeeIdm->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Employee Idm'), ['action' => 'delete', $employeeIdm->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeIdm->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Employee Idm'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Employee Idm'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="employeeIdm view content">
            <h3><?= h($employeeIdm->idm) ?></h3>
            <table>
                <tr>
                    <th><?= __('Employee') ?></th>
                    <td><?= $employeeIdm->has('employee') ? $this->Html->link($employeeIdm->employee->employee_name, ['controller' => 'Employees', 'action' => 'view', $employeeIdm->employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Idm') ?></th>
                    <td><?= h($employeeIdm->idm) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($employeeIdm->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($employeeIdm->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($employeeIdm->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active Flag') ?></th>
                    <td><?= $employeeIdm->active_flag ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
