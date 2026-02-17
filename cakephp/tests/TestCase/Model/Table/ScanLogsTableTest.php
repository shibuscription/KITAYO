<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScanLogsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ScanLogsTable Test Case
 */
class ScanLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ScanLogsTable
     */
    protected $ScanLogs;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.ScanLogs',
        'app.Devices',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ScanLogs') ? [] : ['className' => ScanLogsTable::class];
        $this->ScanLogs = $this->getTableLocator()->get('ScanLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ScanLogs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ScanLogsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ScanLogsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
