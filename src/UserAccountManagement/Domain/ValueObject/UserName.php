<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\ValueObject;

use App\UserAccountManagement\Domain\ErrorMessage;
use Assert\Assert;

final class UserName
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
