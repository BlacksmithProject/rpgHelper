<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement\Entity;

use App\PlayerAccountManagement\Domain\Entity\Token;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\PlayerAccountManagement\Domain\ValueObject\TokenId;
use App\PlayerAccountManagement\Domain\ValueObject\TokenType;
use App\PlayerAccountManagement\Domain\ValueObject\TokenValue;
use App\Tests\Domain\PlayerAccountManagement\BaseTestCase;

final class TokenTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $token = Token::generate(
            $this->generateTokenId(),
            $this->generatePlayerId(),
            TokenValue::generate(),
            new \DateTimeImmutable(),
            TokenType::AUTHENTICATION()
        );

        $this->assertInstanceOf(TokenId::class, $token->id());
        $this->assertInstanceOf(PlayerId::class, $token->playerId());
        $this->assertInstanceOf(TokenValue::class, $token->value());
        $this->assertInstanceOf(\DateTimeImmutable::class, $token->expireAt());
        $this->assertInstanceOf(TokenType::class, $token->type());
        $this->assertFalse($token->isExpired());
    }

    public function testIsExpiredReturnFalseWhenTokenIsExpired(): void
    {
        $token = Token::generate(
            $this->generateTokenId(),
            $this->generatePlayerId(),
            TokenValue::generate(),
            (new \DateTimeImmutable())->sub(new \DateInterval('P16D')),
            TokenType::AUTHENTICATION()
        );

        $this->assertTrue($token->isExpired());
    }
}
