<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\ValueObject;

interface CredentialsId
{
    public function __toString();
}
