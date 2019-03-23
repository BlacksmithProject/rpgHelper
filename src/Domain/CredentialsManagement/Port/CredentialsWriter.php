<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Port;

use App\Domain\CredentialsManagement\Entity\Credentials;

interface CredentialsWriter
{
    public function add(Credentials $credentials): void;
}
