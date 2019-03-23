<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\Query;

use App\Domain\UserAccountManagement\Entity\User;
use App\Domain\UserAccountManagement\Port\UserReader;
use App\Domain\UserAccountManagement\ValueObject\UserId;

final class FindUserWithId
{
    private $userReader;

    public function __construct(UserReader $userReader)
    {
        $this->userReader = $userReader;
    }

    public function __invoke(UserId $userId): User
    {
        return $this->userReader->get($userId);
    }
}
