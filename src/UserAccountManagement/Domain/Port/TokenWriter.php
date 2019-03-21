<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\Port;

use App\UserAccountManagement\Domain\Entity\Token;

interface TokenWriter
{
    public function add(Token $token): void;
}
