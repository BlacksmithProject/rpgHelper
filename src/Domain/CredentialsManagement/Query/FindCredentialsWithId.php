<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Query;

use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\Port\CredentialsReader;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;

final class FindCredentialsWithId
{
    private $credentialsReader;

    public function __construct(CredentialsReader $credentialsReader)
    {
        $this->credentialsReader = $credentialsReader;
    }

    public function __invoke(CredentialsId $credentialsId): Credentials
    {
        return $this->credentialsReader->get($credentialsId);
    }
}
