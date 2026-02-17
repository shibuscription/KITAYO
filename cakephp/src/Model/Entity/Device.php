<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Device Entity
 *
 * @property int $id
 * @property int $company_id
 * @property string $device_id
 * @property string|null $device_name
 * @property string|null $location
 * @property bool|null $active_flag
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Device $device
 * @property \App\Model\Entity\ScanLog[] $scan_logs
 */
class Device extends Entity
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
        'device_id' => true,
        'device_name' => true,
        'location' => true,
        'active_flag' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'device' => true,
        'scan_logs' => true,
    ];
}
