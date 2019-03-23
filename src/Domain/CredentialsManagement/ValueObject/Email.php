<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\ValueObject;

use App\Domain\CredentialsManagement\ErrorMessage;
use Assert\Assert;

final class Email
{
    private $value;

    public function __construct(?string $email)
    {
        Assert::that($email)
            ->notNull((string) ErrorMessage::EMAIL_CANNOT_BE_NULL())
            ->notBlank((string) ErrorMessage::EMAIL_CANNOT_BE_BLANK())
            ->email((string) ErrorMessage::EMAIL_MUST_BE_VALID());

        $this->value = $email;
    }

    public function __toString()
    {
        return $this->value;
    }
}
