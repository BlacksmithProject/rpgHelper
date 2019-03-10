<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Port;

use App\Domain\PlayerAccountManagement\Entity\Token;

interface TokenWriter
{
    public function add(Token $token): void;
}
