<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\ValueObject;

use App\Domain\PlayerAccountManagement\ErrorMessage;
use App\Infrastructure\Exception\InternalException;
use Assert\Assert;
use Ramsey\Uuid\Uuid;

final class TokenValue
{
    private $value;

    public function __construct(?string $value)
    {
        Assert::that($value)
            ->notNull((string) ErrorMessage::TOKEN_VALUE_CANNOT_BE_NULL())
            ->notBlank((string) ErrorMessage::TOKEN_VALUE_CANNOT_BE_BLANK());

        $this->value = $value;
    }

    /**
     * @throws InternalException
     */
    public static function generate(): self
    {
        try {
            $random = random_bytes(12);
            $value = base64_encode(sprintf('%s%s', $random, Uuid::uuid4()->toString()));
        } catch (\Exception $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        return new self($value);
    }

    public function __toString()
    {
        return $this->value;
    }
}
