<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ScanLogsFixture
 */
class ScanLogsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'idm' => 'Lorem ipsum dolor sit amet',
                'device_id' => 'Lorem ipsum dolor sit amet',
                'scanned_at' => '2025-11-24 21:32:34',
                'processed' => 1,
            ],
        ];
        parent::init();
    }
}
