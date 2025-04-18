<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\IdentityInterface;

/**
 * User Entity
 *
 * @property int $id
 * @property string $role
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\BorrowRequest[] $borrow_requests
 */
class User extends Entity implements IdentityInterface
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'role' => true,
        'name' => true,
        'email' => true,
        'password' => true,
        'created' => true,
        'modified' => true,
        'borrow_requests' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var list<string>
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * Auto-hash password before saving.
     */
    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new \Authentication\PasswordHasher\DefaultPasswordHasher())->hash($password);
        }
        return null;
    }

    /**
     * Required by IdentityInterface
     */
    public function getIdentifier(): int|string|null
    {
        return $this->id ?? null;
    }

    /**
     * Required by IdentityInterface
     */
    public function getOriginalData(): array|\ArrayAccess
    {
        return $this;
    }
}
