<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AttendanceRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AttendanceRecordsTable Test Case
 */
class AttendanceRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AttendanceRecordsTable
     */
    protected $AttendanceRecords;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.AttendanceRecords',
        'app.Employees',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AttendanceRecords') ? [] : ['className' => AttendanceRecordsTable::class];
        $this->AttendanceRecords = $this->getTableLocator()->get('AttendanceRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AttendanceRecords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AttendanceRecordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AttendanceRecordsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
