<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Port;

use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\ValueObject\Email;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;

interface CredentialsReader
{
    public function isEmailAlreadyUsed(Email $email): bool;

    public function get(CredentialsId $credentialsId): Credentials;

    public function findWithEmail(Email $email): Credentials;
}
