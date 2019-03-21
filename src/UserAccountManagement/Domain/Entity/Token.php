<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\Entity;

use App\UserAccountManagement\Domain\ValueObject\UserId;
use App\UserAccountManagement\Domain\ValueObject\TokenId;
use App\UserAccountManagement\Domain\ValueObject\TokenType;
use App\UserAccountManagement\Domain\ValueObject\TokenValue;
use App\Shared\Infrastructure\Exception\InternalException;

final class Token
{
    private $id;
    private $userId;
    private $value;
    private $expireAt;
    private $type;

    public function __construct(
        TokenId $tokenId,
        UserId $userId,
        TokenValue $tokenValue,
        \DateTimeImmutable $expireAt,
        TokenType $tokenType
    ) {
        $this->id = $tokenId;
        $this->value = $tokenValue;
        $this->expireAt = $expireAt;
        $this->userId = $userId;
        $this->type = $tokenType;
    }

    /**
     * @throws InternalException
     */
    public static function generate(
        TokenId $tokenId,
        UserId $userId,
        TokenValue $tokenValue,
        \DateTimeImmutable $currentDateTime,
        TokenType $tokenType
    ): self {
        try {
            $expireAt = $currentDateTime->add(new \DateInterval('P15D'));
        } catch (\Exception $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        return new self($tokenId, $userId, $tokenValue, $expireAt, $tokenType);
    }

    public function id(): TokenId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
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
