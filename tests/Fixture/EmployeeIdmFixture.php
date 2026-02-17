<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmployeeIdmFixture
 */
class EmployeeIdmFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'employee_idm';
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
                'employee_id' => 1,
                'idm' => 'Lorem ipsum dolor sit amet',
                'active_flag' => 1,
                'created' => '2025-11-24 21:32:31',
                'modified' => '2025-11-24 21:32:31',
            ],
        ];
        parent::init();
    }
}
