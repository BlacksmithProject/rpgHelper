<?php
declare(strict_types=1);

namespace App\Domain\GameManagement\ValueObject;

use App\Domain\GameManagement\ErrorMessage;
use Assert\Assert;

final class PlayerName
{
    private $value;

    public function __construct(?string $value)
    {
        Assert::that($value)
            ->notNull((string) ErrorMessage::PLAYER_NAME_CANNOT_BE_NULL())
            ->notBlank((string) ErrorMessage::PLAYER_NAME_CANNOT_BE_BLANK());

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
