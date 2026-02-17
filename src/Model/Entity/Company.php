<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Company Entity
 *
 * @property int $id
 * @property string $company_name
 * @property bool|null $active_flag
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Device[] $devices
 * @property \App\Model\Entity\Employee[] $employees
 * @property \App\Model\Entity\User[] $users
 */
class Company extends Entity
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
        'company_name' => true,
        'active_flag' => true,
        'created' => true,
        'modified' => true,
        'devices' => true,
        'employees' => true,
        'users' => true,
    ];
}
