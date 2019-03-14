<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\Port;

use App\PlayerAccountManagement\Domain\Entity\Token;

interface TokenWriter
{
    public function add(Token $token): void;
}
