<?php
declare(strict_types=1);

namespace App\Tests\UserAccountManagement\Domain\Entity;

use App\UserAccountManagement\Domain\Entity\Token;
use App\UserAccountManagement\Domain\ValueObject\UserId;
use App\UserAccountManagement\Domain\ValueObject\TokenId;
use App\UserAccountManagement\Domain\ValueObject\TokenType;
use App\UserAccountManagement\Domain\ValueObject\TokenValue;
use App\Tests\UserAccountManagement\Domain\BaseTestCase;

final class TokenTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $token = Token::generate(
            $this->generateTokenId(),
            $this->generateUserId(),
            TokenValue::generate(),
            new \DateTimeImmutable(),
            TokenType::AUTHENTICATION()
        );

        $this->assertInstanceOf(TokenId::class, $token->id());
        $this->assertInstanceOf(UserId::class, $token->userId());
        $this->assertInstanceOf(TokenValue::class, $token->value());
        $this->assertInstanceOf(\DateTimeImmutable::class, $token->expireAt());
        $this->assertInstanceOf(TokenType::class, $token->type());
        $this->assertFalse($token->isExpired());
    }

    public function testIsExpiredReturnFalseWhenTokenIsExpired(): void
    {
        $token = Token::generate(
            $this->generateTokenId(),
            $this->generateUserId(),
            TokenValue::generate(),
            (new \DateTimeImmutable())->sub(new \DateInterval('P16D')),
            TokenType::AUTHENTICATION()
        );

        $this->assertTrue($token->isExpired());
    }
}
