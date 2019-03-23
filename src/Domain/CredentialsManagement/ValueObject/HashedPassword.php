<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\ValueObject;

use App\Infrastructure\Shared\Exception\InternalException;

final class HashedPassword
{
    private $value;

    private function __construct(string $hash)
    {
        $this->value = $hash;
    }

    /**
     * @throws InternalException
     */
    public static function fromPlainPassword(PlainPassword $plainPassword): self
    {
        $hashedPassword = password_hash((string) $plainPassword, PASSWORD_BCRYPT);

        if (false === $hashedPassword) {
            throw new InternalException();
        }

        return new self($hashedPassword);
    }

    public static function fromHash(string $hash): self
    {
        return new self($hash);
    }

    public function __toString()
    {
        return $this->value;
    }

    public function isSameThan(PlainPassword $plainPassword): bool
    {
        return password_verify((string) $plainPassword, $this->value);
    }
}
