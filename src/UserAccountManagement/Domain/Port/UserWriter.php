<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\Port;

use App\UserAccountManagement\Domain\Entity\User;

interface UserWriter
{
    public function add(User $user): void;
}
