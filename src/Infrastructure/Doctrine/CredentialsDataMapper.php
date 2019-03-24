<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\ValueObject\Email;
use App\Domain\CredentialsManagement\ValueObject\HashedPassword;
use App\Application\Shared\Identity;
use Ramsey\Uuid\Uuid;

final class CredentialsDataMapper
{
    private $id;
    private $email;
    private $hashedPassword;

    public function __construct(Credentials $credentials)
    {
        $this->id = Uuid::fromString((string) $credentials->id());
        $this->email = (string) $credentials->email();
        $this->hashedPassword = (string) $credentials->hashedPassword();
    }

    public function toCredentials(): Credentials
    {
        return new Credentials(
            Identity::fromString($this->id->toString()),
            new Email($this->email),
            HashedPassword::fromHash($this->hashedPassword)
        );
    }
}
