<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Infrastructure\Doctrine;

use App\UserAccountManagement\Domain\Entity\User;
use App\UserAccountManagement\Domain\ValueObject\Email;
use App\UserAccountManagement\Domain\ValueObject\HashedPassword;
use App\UserAccountManagement\Domain\ValueObject\UserName;
use App\Shared\Application\Identity;
use Ramsey\Uuid\Uuid;

final class UserDataMapper
{
    private $id;
    private $email;
    private $hashedPassword;
    private $name;

    public function __construct(User $user)
    {
        $this->id = Uuid::fromString((string) $user->id());
        $this->email = (string) $user->email();
        $this->hashedPassword = (string) $user->hashedPassword();
        $this->name = (string) $user->name();
    }

    public function toUser(): User
    {
        return new User(
            Identity::fromString($this->id->toString()),
            new Email($this->email),
            HashedPassword::fromHash($this->hashedPassword),
            new UserName($this->name)
        );
    }
}
