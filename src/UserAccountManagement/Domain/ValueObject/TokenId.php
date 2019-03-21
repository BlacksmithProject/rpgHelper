<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\ValueObject;

interface TokenId
{
    public function __toString();
}
