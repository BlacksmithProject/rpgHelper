<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Entity;

use App\Domain\CredentialsManagement\ValueObject\Email;
use App\Domain\CredentialsManagement\ValueObject\HashedPassword;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;

final class Credentials
{
    private $id;
    private $email;
    private $hashedPassword;

    public function __construct(
        CredentialsId $credentialsId,
        Email $email,
        HashedPassword $hashedPassword
    ) {
        $this->id = $credentialsId;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    public function id(): CredentialsId
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }
}
