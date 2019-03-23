<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Port;

use App\Domain\CredentialsManagement\Entity\Token;

interface TokenWriter
{
    public function add(Token $token): void;
}
