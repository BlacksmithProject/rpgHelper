<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\Port;

use App\Domain\UserAccountManagement\Entity\User;
use App\Domain\UserAccountManagement\ValueObject\Email;
use App\Domain\UserAccountManagement\ValueObject\UserId;
use App\Domain\UserAccountManagement\ValueObject\UserName;

interface UserReader
{
    public function isEmailAlreadyUsed(Email $email): bool;

    public function isNameAlreadyUsed(UserName $userName): bool;

    public function get(UserId $userId): User;

    public function findWithEmail(Email $email): User;
}
