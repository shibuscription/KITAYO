<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Employee'), ['action' => 'edit', $employee->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Employee'), ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Employees'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Employee'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="employees view content">
            <h3><?= h($employee->employee_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $employee->has('company') ? $this->Html->link($employee->company->company_name, ['controller' => 'Companies', 'action' => 'view', $employee->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Employee Name') ?></th>
                    <td><?= h($employee->employee_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($employee->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($employee->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($employee->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active Flag') ?></th>
                    <td><?= $employee->active_flag ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Attendance Records') ?></h4>
                <?php if (!empty($employee->attendance_records)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Employee Id') ?></th>
                            <th><?= __('Work Date') ?></th>
                            <th><?= __('Check In') ?></th>
                            <th><?= __('Check Out') ?></th>
                            <th><?= __('Break Start') ?></th>
                            <th><?= __('Break End') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Note') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($employee->attendance_records as $attendanceRecords) : ?>
                        <tr>
                            <td><?= h($attendanceRecords->id) ?></td>
                            <td><?= h($attendanceRecords->employee_id) ?></td>
                            <td><?= h($attendanceRecords->work_date) ?></td>
                            <td><?= h($attendanceRecords->check_in) ?></td>
                            <td><?= h($attendanceRecords->check_out) ?></td>
                            <td><?= h($attendanceRecords->break_start) ?></td>
                            <td><?= h($attendanceRecords->break_end) ?></td>
                            <td><?= h($attendanceRecords->status) ?></td>
                            <td><?= h($attendanceRecords->note) ?></td>
                            <td><?= h($attendanceRecords->created) ?></td>
                            <td><?= h($attendanceRecords->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AttendanceRecords', 'action' => 'view', $attendanceRecords->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AttendanceRecords', 'action' => 'edit', $attendanceRecords->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AttendanceRecords', 'action' => 'delete', $attendanceRecords->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attendanceRecords->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Employee Idm') ?></h4>
                <?php if (!empty($employee->employee_idm)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Employee Id') ?></th>
                            <th><?= __('Idm') ?></th>
                            <th><?= __('Active Flag') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($employee->employee_idm as $employeeIdm) : ?>
                        <tr>
                            <td><?= h($employeeIdm->id) ?></td>
                            <td><?= h($employeeIdm->employee_id) ?></td>
                            <td><?= h($employeeIdm->idm) ?></td>
                            <td><?= h($employeeIdm->active_flag) ?></td>
                            <td><?= h($employeeIdm->created) ?></td>
                            <td><?= h($employeeIdm->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'EmployeeIdm', 'action' => 'view', $employeeIdm->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'EmployeeIdm', 'action' => 'edit', $employeeIdm->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'EmployeeIdm', 'action' => 'delete', $employeeIdm->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeIdm->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($employee->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Username') ?></th>
                            <th><?= __('Password Hash') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Employee Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($employee->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->username) ?></td>
                            <td><?= h($users->password_hash) ?></td>
                            <td><?= h($users->role) ?></td>
                            <td><?= h($users->company_id) ?></td>
                            <td><?= h($users->employee_id) ?></td>
                            <td><?= h($users->created) ?></td>
                            <td><?= h($users->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
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
