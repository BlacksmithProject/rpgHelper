<?php
declare(strict_types=1);

namespace App\Infrastructure\UserAccountManagement\Doctrine;

use App\Domain\UserAccountManagement\Entity\Token;
use App\Domain\UserAccountManagement\ValueObject\TokenType;
use App\Domain\UserAccountManagement\ValueObject\TokenValue;
use App\Application\Shared\Identity;
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
