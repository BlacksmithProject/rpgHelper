<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\Port;

use App\Domain\UserAccountManagement\Entity\Token;
use App\Domain\UserAccountManagement\ValueObject\UserId;
use App\Domain\UserAccountManagement\ValueObject\TokenId;
use App\Domain\UserAccountManagement\ValueObject\TokenType;

interface TokenReader
{
    public function get(TokenId $tokenId): Token;

    public function findWithUserIdAndType(UserId $userId, TokenType $tokenType): Token;
}
