<?php
declare(strict_types=1);

namespace App\Infrastructure\CredentialsManagement\Doctrine;

use App\Domain\CredentialsManagement\Entity\Token;
use App\Domain\CredentialsManagement\ValueObject\TokenType;
use App\Domain\CredentialsManagement\ValueObject\TokenValue;
use App\Application\Shared\Identity;
use Ramsey\Uuid\Uuid;

final class TokenDataMapper
{
    private $id;
    private $credentialsId;
    private $value;
    private $expireAt;
    private $type;

    public function __construct(Token $token)
    {
        $this->id = Uuid::fromString((string) $token->id());
        $this->credentialsId = Uuid::fromString((string) $token->credentialsId());
        $this->value = (string) $token->value();
        $this->expireAt = $token->expireAt();
        $this->type = (string) $token->type();
    }

    public function toToken(): Token
    {
        return new Token(
            Identity::fromString((string) $this->id),
            Identity::fromString((string) $this->credentialsId),
            new TokenValue($this->value),
            $this->expireAt,
            new TokenType($this->type)
        );
    }
}
