<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Player;

use App\Domain\PlayerAccountManagement\Entity\Token;
use App\Domain\PlayerAccountManagement\ValueObject\TokenType;
use App\Domain\PlayerAccountManagement\ValueObject\TokenValue;
use App\Application\Shared\Identity;
use Ramsey\Uuid\Uuid;

final class TokenDataMapper
{
    private $id;
    private $playerId;
    private $value;
    private $expireAt;
    private $type;

    public function __construct(Token $token)
    {
        $this->id = Uuid::fromString((string) $token->id());
        $this->playerId = Uuid::fromString((string) $token->playerId());
        $this->value = (string) $token->value();
        $this->expireAt = $token->expireAt();
        $this->type = (string) $token->type();
    }

    public function toToken(): Token
    {
        return new Token(
            Identity::fromString((string) $this->id),
            Identity::fromString((string) $this->playerId),
            new TokenValue($this->value),
            $this->expireAt,
            new TokenType($this->type)
        );
    }
}
