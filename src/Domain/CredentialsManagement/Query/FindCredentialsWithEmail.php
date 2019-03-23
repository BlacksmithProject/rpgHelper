<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Query;

use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\Port\CredentialsReader;
use App\Domain\CredentialsManagement\ValueObject\Email;

final class FindCredentialsWithEmail
{
    private $credentialsReader;

    public function __construct(CredentialsReader $credentialsReader)
    {
        $this->credentialsReader = $credentialsReader;
    }

    public function __invoke(Email $email): Credentials
    {
        return $this->credentialsReader->findWithEmail($email);
    }
}
