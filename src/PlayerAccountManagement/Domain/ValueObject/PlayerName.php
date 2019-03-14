<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\ValueObject;

use App\PlayerAccountManagement\Domain\ErrorMessage;
use Assert\Assert;

final class PlayerName
{
    private $value;

    public function __construct(?string $name)
    {
        Assert::that($name)
            ->notNull((string) ErrorMessage::NAME_CANNOT_BE_NULL())
            ->notBlank((string) ErrorMessage::NAME_CANNOT_BE_BLANK());

        $this->value = $name;
    }

    public function __toString()
    {
        return $this->value;
    }
}
