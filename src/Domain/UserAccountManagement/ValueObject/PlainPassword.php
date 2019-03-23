<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\ValueObject;

use App\Domain\UserAccountManagement\ErrorMessage;
use Assert\Assert;

final class PlainPassword
{
    private $value;

    public function __construct(?string $password)
    {
        Assert::that($password)
            ->notNull((string) ErrorMessage::PASSWORD_CANNOT_BE_NULL())
            ->notBlank((string) ErrorMessage::PASSWORD_CANNOT_BE_BLANK());

        $this->value = $password;
    }

    public function __toString()
    {
        return $this->value;
    }
}
