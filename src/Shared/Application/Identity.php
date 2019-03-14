<?php
declare(strict_types=1);

namespace App\Shared\Application;

use App\PlayerAccountManagement\Domain\ValueObject\CredentialsId;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\PlayerAccountManagement\Domain\ValueObject\TokenId;
use App\Shared\Infrastructure\Exception\InternalException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Identity implements CredentialsId, TokenId, PlayerId
{
    private $value;

    private function __construct(UuidInterface $uuid)
    {
        $this->value = $uuid;
    }

    /**
     * @throws InternalException
     */
    public static function generate(): self
    {
        try {
            return new self(Uuid::uuid4());
        } catch (\Exception $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public static function fromString(string $value): self
    {
        return new self(Uuid::fromString($value));
    }

    public function __toString()
    {
        return $this->value->toString();
    }
}
