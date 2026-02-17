<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ScanLog Entity
 *
 * @property int $id
 * @property string $idm
 * @property string $device_id
 * @property \Cake\I18n\FrozenTime $scanned_at
 * @property bool|null $processed
 *
 * @property \App\Model\Entity\Device $device
 */
class ScanLog extends Entity
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
        'idm' => true,
        'device_id' => true,
        'scanned_at' => true,
        'processed' => true,
        'device' => true,
    ];
}
