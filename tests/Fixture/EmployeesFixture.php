<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmployeesFixture
 */
class EmployeesFixture extends TestFixture
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
                'employee_name' => 'Lorem ipsum dolor sit amet',
                'active_flag' => 1,
                'created' => '2025-11-24 21:32:29',
                'modified' => '2025-11-24 21:32:29',
            ],
        ];
        parent::init();
    }
}
