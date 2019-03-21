<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Infrastructure\Doctrine;

use App\UserAccountManagement\Domain\Entity\Token;
use App\UserAccountManagement\Domain\ValueObject\TokenType;
use App\UserAccountManagement\Domain\ValueObject\TokenValue;
use App\Shared\Application\Identity;
use Ramsey\Uuid\Uuid;

final class TokenDataMapper
{
    private $id;
    private $userId;
    private $value;
    private $expireAt;
    private $type;

    public function __construct(Token $token)
    {
        $this->id = Uuid::fromString((string) $token->id());
        $this->userId = Uuid::fromString((string) $token->userId());
        $this->value = (string) $token->value();
        $this->expireAt = $token->expireAt();
        $this->type = (string) $token->type();
    }

    public function toToken(): Token
    {
        return new Token(
            Identity::fromString((string) $this->id),
            Identity::fromString((string) $this->userId),
            new TokenValue($this->value),
            $this->expireAt,
            new TokenType($this->type)
        );
    }
}
