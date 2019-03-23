<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Port;

use App\Domain\CredentialsManagement\Entity\Token;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;
use App\Domain\CredentialsManagement\ValueObject\TokenId;
use App\Domain\CredentialsManagement\ValueObject\TokenType;

interface TokenReader
{
    public function get(TokenId $tokenId): Token;

    public function findWithcredentialsIdAndType(CredentialsId $credentialsId, TokenType $tokenType): Token;
}
