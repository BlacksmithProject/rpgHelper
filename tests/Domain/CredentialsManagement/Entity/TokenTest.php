<?php
declare(strict_types=1);

namespace App\Tests\Domain\CredentialsManagement\Entity;

use App\Domain\CredentialsManagement\Entity\Token;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;
use App\Domain\CredentialsManagement\ValueObject\TokenId;
use App\Domain\CredentialsManagement\ValueObject\TokenType;
use App\Domain\CredentialsManagement\ValueObject\TokenValue;
use App\Tests\Domain\CredentialsManagement\BaseTestCase;

final class TokenTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $token = Token::generate(
            $this->generateTokenId(),
            $this->generateCredentialsId(),
            TokenValue::generate(),
            new \DateTimeImmutable(),
            TokenType::AUTHENTICATION()
        );

        $this->assertInstanceOf(TokenId::class, $token->id());
        $this->assertInstanceOf(CredentialsId::class, $token->credentialsId());
        $this->assertInstanceOf(TokenValue::class, $token->value());
        $this->assertInstanceOf(\DateTimeImmutable::class, $token->expireAt());
        $this->assertInstanceOf(TokenType::class, $token->type());
        $this->assertFalse($token->isExpired());
    }

    public function testIsExpiredReturnFalseWhenTokenIsExpired(): void
    {
        $token = Token::generate(
            $this->generateTokenId(),
            $this->generatecredentialsId(),
            TokenValue::generate(),
            (new \DateTimeImmutable())->sub(new \DateInterval('P16D')),
            TokenType::AUTHENTICATION()
        );

        $this->assertTrue($token->isExpired());
    }
}
