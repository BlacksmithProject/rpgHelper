<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\ValueObject;

interface TokenId
{
    public function __toString();
}
