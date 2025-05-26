<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            // ✅ Admin user for AdminsController tests
            [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@uao.test',
                'password' => 'admin123', // You can replace this with a hashed password if needed
                'role' => 'admin',
                'is_verified' => true,
                'otp_code' => null,
                'otp_expires_at' => null,
                'created' => '2025-01-01 00:00:00',
                'modified' => '2025-01-01 00:00:00'
            ],

            // ✅ Borrower user for BorrowRequestsController tests
            [
                'id' => 2,
                'name' => 'Test User',
                'email' => 'test@my.xu.edu.ph',
                'password' => 'password',
                'role' => 'borrower',
                'is_verified' => true,
                'otp_code' => null,
                'otp_expires_at' => null,
                'created' => '2025-01-01 00:00:00',
                'modified' => '2025-01-01 00:00:00'
            ],
        ];

        parent::init();
    }
}
