<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\Query;

use App\Domain\UserAccountManagement\Entity\User;
use App\Domain\UserAccountManagement\Port\UserReader;
use App\Domain\UserAccountManagement\ValueObject\Email;

final class FindUserWithEmail
{
    private $userReader;

    public function __construct(UserReader $userReader)
    {
        $this->userReader = $userReader;
    }

    public function __invoke(Email $email): User
    {
        return $this->userReader->findWithEmail($email);
    }
}
