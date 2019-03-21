<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\Query;

use App\UserAccountManagement\Domain\Entity\Token;
use App\UserAccountManagement\Domain\Port\TokenReader;
use App\UserAccountManagement\Domain\ValueObject\UserId;
use App\UserAccountManagement\Domain\ValueObject\TokenType;

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
