<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Entity;

use App\Domain\CredentialsManagement\ValueObject\CredentialsId;
use App\Domain\CredentialsManagement\ValueObject\TokenId;
use App\Domain\CredentialsManagement\ValueObject\TokenType;
use App\Domain\CredentialsManagement\ValueObject\TokenValue;
use App\Infrastructure\Shared\Exception\InternalException;

final class Token
{
    private $id;
    private $credentialsId;
    private $value;
    private $expireAt;
    private $type;

    public function __construct(
        TokenId $tokenId,
        credentialsId $credentialsId,
        TokenValue $tokenValue,
        \DateTimeImmutable $expireAt,
        TokenType $tokenType
    ) {
        $this->id = $tokenId;
        $this->value = $tokenValue;
        $this->expireAt = $expireAt;
        $this->credentialsId = $credentialsId;
        $this->type = $tokenType;
    }

    /**
     * @throws InternalException
     */
    public static function generate(
        TokenId $tokenId,
        CredentialsId $credentialsId,
        TokenValue $tokenValue,
        \DateTimeImmutable $currentDateTime,
        TokenType $tokenType
    ): self {
        try {
            $expireAt = $currentDateTime->add(new \DateInterval('P15D'));
        } catch (\Exception $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        return new self($tokenId, $credentialsId, $tokenValue, $expireAt, $tokenType);
    }

    public function id(): TokenId
    {
        return $this->id;
    }

    public function credentialsId(): CredentialsId
    {
        return $this->credentialsId;
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
