<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Command\CredentialsRegistration;

use App\Domain\CredentialsManagement\ValueObject\CredentialsId;
use App\Domain\CredentialsManagement\ValueObject\TokenId;

final class RegisterAuthenticationToken
{
    private $tokenId;
    private $credentialsId;

    public function __construct(TokenId $tokenId, credentialsId $credentialsId)
    {
        $this->tokenId = $tokenId;
        $this->credentialsId = $credentialsId;
    }

    public function tokenId(): TokenId
    {
        return $this->tokenId;
    }

    public function credentialsId(): credentialsId
    {
        return $this->credentialsId;
    }
}
