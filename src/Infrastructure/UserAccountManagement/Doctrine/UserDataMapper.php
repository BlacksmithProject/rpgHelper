<?php
declare(strict_types=1);

namespace App\Infrastructure\UserAccountManagement\Doctrine;

use App\Domain\UserAccountManagement\Entity\User;
use App\Domain\UserAccountManagement\ValueObject\Email;
use App\Domain\UserAccountManagement\ValueObject\HashedPassword;
use App\Domain\UserAccountManagement\ValueObject\UserName;
use App\Application\Shared\Identity;
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
