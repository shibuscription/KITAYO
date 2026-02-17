<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Employee Entity
 *
 * @property int $id
 * @property int $company_id
 * @property string $employee_name
 * @property bool|null $active_flag
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\AttendanceRecord[] $attendance_records
 * @property \App\Model\Entity\EmployeeIdm[] $employee_idm
 * @property \App\Model\Entity\User[] $users
 */
class Employee extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'company_id' => true,
        'employee_name' => true,
        'active_flag' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'attendance_records' => true,
        'employee_idm' => true,
        'users' => true,
    ];
}
