<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\Port;

use App\Domain\UserAccountManagement\Entity\Token;

interface TokenWriter
{
    public function add(Token $token): void;
}
