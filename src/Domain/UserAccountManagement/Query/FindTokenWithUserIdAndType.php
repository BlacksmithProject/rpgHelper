<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\Query;

use App\Domain\UserAccountManagement\Entity\Token;
use App\Domain\UserAccountManagement\Port\TokenReader;
use App\Domain\UserAccountManagement\ValueObject\UserId;
use App\Domain\UserAccountManagement\ValueObject\TokenType;

final class FindTokenWithUserIdAndType
{
    private $tokenReader;

    public function __construct(TokenReader $tokenReader)
    {
        $this->tokenReader = $tokenReader;
    }

    public function __invoke(UserId $userId, TokenType $tokenType): Token
    {
        return $this->tokenReader->findWithUserIdAndType($userId, $tokenType);
    }
}
