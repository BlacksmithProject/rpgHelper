<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\Port;

use App\UserAccountManagement\Domain\Entity\User;
use App\UserAccountManagement\Domain\ValueObject\Email;
use App\UserAccountManagement\Domain\ValueObject\UserId;
use App\UserAccountManagement\Domain\ValueObject\UserName;

interface UserReader
{
    public function isEmailAlreadyUsed(Email $email): bool;

    public function isNameAlreadyUsed(UserName $userName): bool;

    public function get(UserId $userId): User;

    public function findWithEmail(Email $email): User;
}
