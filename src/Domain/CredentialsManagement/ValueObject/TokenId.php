<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\ValueObject;

interface TokenId
{
    public function __toString();
}
