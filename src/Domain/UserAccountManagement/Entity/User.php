<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\Entity;

use App\Domain\UserAccountManagement\ValueObject\Email;
use App\Domain\UserAccountManagement\ValueObject\HashedPassword;
use App\Domain\UserAccountManagement\ValueObject\UserId;
use App\Domain\UserAccountManagement\ValueObject\UserName;

final class User
{
    private $id;
    private $email;
    private $hashedPassword;
    private $name;

    public function __construct(
        UserId $userId,
        Email $email,
        HashedPassword $hashedPassword,
        UserName $userName
    ) {
        $this->id = $userId;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->name = $userName;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

    public function name(): UserName
    {
        return $this->name;
    }
}
