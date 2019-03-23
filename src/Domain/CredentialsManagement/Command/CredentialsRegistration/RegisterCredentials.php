<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Command\CredentialsRegistration;

use App\Domain\CredentialsManagement\ValueObject\Email;
use App\Domain\CredentialsManagement\ValueObject\PlainPassword;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;

final class RegisterCredentials
{
    private $credentialsId;
    private $email;
    private $plainPassword;

    public function __construct(
        CredentialsId $credentialsId,
        ?string $email,
        ?string $plainPassword
    ) {
        $this->credentialsId = $credentialsId;
        $this->email = new Email($email);
        $this->plainPassword = new PlainPassword($plainPassword);
    }

    public function credentialsId(): CredentialsId
    {
        return $this->credentialsId;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function plainPassword(): PlainPassword
    {
        return $this->plainPassword;
    }
}
