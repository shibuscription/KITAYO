<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AttendanceRecordsFixture
 */
class AttendanceRecordsFixture extends TestFixture
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
                'employee_id' => 1,
                'work_date' => '2025-11-24',
                'check_in' => '2025-11-24 21:32:36',
                'check_out' => '2025-11-24 21:32:36',
                'break_start' => '2025-11-24 21:32:36',
                'break_end' => '2025-11-24 21:32:36',
                'status' => 'Lorem ipsum dolor sit amet',
                'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2025-11-24 21:32:36',
                'modified' => '2025-11-24 21:32:36',
            ],
        ];
        parent::init();
    }
}
