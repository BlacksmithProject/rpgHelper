<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\Port;

use App\UserAccountManagement\Domain\Entity\Token;
use App\UserAccountManagement\Domain\ValueObject\UserId;
use App\UserAccountManagement\Domain\ValueObject\TokenId;
use App\UserAccountManagement\Domain\ValueObject\TokenType;

interface TokenReader
{
    public function get(TokenId $tokenId): Token;

    public function findWithUserIdAndType(UserId $userId, TokenType $tokenType): Token;
}
