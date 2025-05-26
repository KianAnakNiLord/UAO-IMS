<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.BorrowRequests',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = $this->getTableLocator()->get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Users);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\UsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\UsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
    public function testSaveValidBorrowerUser(): void
{
    $data = [
        'name' => 'Juan Dela Cruz',
        'email' => 'juan@my.xu.edu.ph',
        'password' => 'Password123!',
        'role' => 'borrower',
        'is_verified' => false,
        'otp_code' => '123456',
        'otp_expires_at' => date('Y-m-d H:i:s', strtotime('+10 minutes'))
    ];

    $entity = $this->Users->newEntity($data);

    $this->assertEmpty($entity->getErrors(), 'Validation errors found on valid user data.');

    $saved = $this->Users->save($entity);

    $this->assertNotFalse($saved, 'Valid borrower user could not be saved.');
}

}
