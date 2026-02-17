<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\EmployeeIdm> $employeeIdm
 */
?>
<div class="employeeIdm index content">
    <?= $this->Html->link(__('New Employee Idm'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Employee Idm') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('employee_id') ?></th>
                    <th><?= $this->Paginator->sort('idm') ?></th>
                    <th><?= $this->Paginator->sort('active_flag') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employeeIdm as $employeeIdm): ?>
                <tr>
                    <td><?= $this->Number->format($employeeIdm->id) ?></td>
                    <td><?= $employeeIdm->has('employee') ? $this->Html->link($employeeIdm->employee->employee_name, ['controller' => 'Employees', 'action' => 'view', $employeeIdm->employee->id]) : '' ?></td>
                    <td><?= h($employeeIdm->idm) ?></td>
                    <td><?= h($employeeIdm->active_flag) ?></td>
                    <td><?= h($employeeIdm->created) ?></td>
                    <td><?= h($employeeIdm->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $employeeIdm->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employeeIdm->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employeeIdm->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeIdm->id)]) ?>
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
