<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Query;

use App\Domain\CredentialsManagement\Entity\Token;
use App\Domain\CredentialsManagement\Port\TokenReader;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;
use App\Domain\CredentialsManagement\ValueObject\TokenType;

final class FindTokenWithCredentialsIdAndType
{
    private $tokenReader;

    public function __construct(TokenReader $tokenReader)
    {
        $this->tokenReader = $tokenReader;
    }

    public function __invoke(CredentialsId $credentialsId, TokenType $tokenType): Token
    {
        return $this->tokenReader->findWithcredentialsIdAndType($credentialsId, $tokenType);
    }
}
