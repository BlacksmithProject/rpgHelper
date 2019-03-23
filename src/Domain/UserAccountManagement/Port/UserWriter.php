<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\Port;

use App\Domain\UserAccountManagement\Entity\User;

interface UserWriter
{
    public function add(User $user): void;
}
