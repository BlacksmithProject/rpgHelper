<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\Command\UserRegistration;

use App\UserAccountManagement\Domain\ValueObject\Email;
use App\UserAccountManagement\Domain\ValueObject\PlainPassword;
use App\UserAccountManagement\Domain\ValueObject\UserId;
use App\UserAccountManagement\Domain\ValueObject\UserName;

final class RegisterUser
{
    private $userId;
    private $email;
    private $plainPassword;
    private $userName;

    public function __construct(
        UserId $userId,
        ?string $email,
        ?string $plainPassword,
        ?string $userName
    ) {
        $this->userId = $userId;
        $this->email = new Email($email);
        $this->plainPassword = new PlainPassword($plainPassword);
        $this->userName = new UserName($userName);
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function plainPassword(): PlainPassword
    {
        return $this->plainPassword;
    }

    public function userName(): UserName
    {
        return $this->userName;
    }
}
