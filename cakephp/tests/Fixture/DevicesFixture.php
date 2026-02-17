<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DevicesFixture
 */
class DevicesFixture extends TestFixture
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
                'company_id' => 1,
                'device_id' => 'Lorem ipsum dolor sit amet',
                'device_name' => 'Lorem ipsum dolor sit amet',
                'location' => 'Lorem ipsum dolor sit amet',
                'active_flag' => 1,
                'created' => '2025-11-24 21:32:32',
                'modified' => '2025-11-24 21:32:32',
            ],
        ];
        parent::init();
    }
}
