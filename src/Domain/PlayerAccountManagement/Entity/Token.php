<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Entity;

use App\Domain\PlayerAccountManagement\ValueObject\PlayerId;
use App\Domain\PlayerAccountManagement\ValueObject\TokenId;
use App\Domain\PlayerAccountManagement\ValueObject\TokenType;
use App\Domain\PlayerAccountManagement\ValueObject\TokenValue;
use App\Infrastructure\Exception\InternalException;

final class Token
{
    private $id;
    private $playerId;
    private $value;
    private $expireAt;
    private $type;

    public function __construct(
        TokenId $tokenId,
        PlayerId $playerId,
        TokenValue $tokenValue,
        \DateTimeImmutable $expireAt,
        TokenType $tokenType
    ) {
        $this->id = $tokenId;
        $this->value = $tokenValue;
        $this->expireAt = $expireAt;
        $this->playerId = $playerId;
        $this->type = $tokenType;
    }

    /**
     * @throws InternalException
     */
    public static function generate(
        TokenId $tokenId,
        PlayerId $playerId,
        TokenValue $tokenValue,
        \DateTimeImmutable $currentDateTime,
        TokenType $tokenType
    ): self {
        try {
            $expireAt = $currentDateTime->add(new \DateInterval('P15D'));
        } catch (\Exception $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        return new self($tokenId, $playerId, $tokenValue, $expireAt, $tokenType);
    }

    public function id(): TokenId
    {
        return $this->id;
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
    }

    public function value(): TokenValue
    {
        return $this->value;
    }

    public function expireAt(): \DateTimeImmutable
    {
        return $this->expireAt;
    }

    public function type(): TokenType
    {
        return $this->type;
    }

    /**
     * @throws InternalException
     */
    public function isExpired(): bool
    {
        try {
            $now = new \DateTimeImmutable();
        } catch (\Exception $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        return $now > $this->expireAt;
    }
}
