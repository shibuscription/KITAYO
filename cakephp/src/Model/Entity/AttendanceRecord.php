<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AttendanceRecord Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property \Cake\I18n\FrozenDate $work_date
 * @property \Cake\I18n\FrozenTime|null $check_in
 * @property \Cake\I18n\FrozenTime|null $check_out
 * @property \Cake\I18n\FrozenTime|null $break_start
 * @property \Cake\I18n\FrozenTime|null $break_end
 * @property string|null $status
 * @property string|null $note
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Employee $employee
 */
class AttendanceRecord extends Entity
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
        'employee_id' => true,
        'work_date' => true,
        'check_in' => true,
        'check_out' => true,
        'break_start' => true,
        'break_end' => true,
        'status' => true,
        'note' => true,
        'created' => true,
        'modified' => true,
        'employee' => true,
    ];
}
