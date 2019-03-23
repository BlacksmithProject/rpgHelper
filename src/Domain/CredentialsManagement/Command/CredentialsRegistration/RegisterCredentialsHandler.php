<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Command\CredentialsRegistration;

use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\ErrorMessage;
use App\Domain\CredentialsManagement\CredentialsManagementException;
use App\Domain\CredentialsManagement\Port\CredentialsReader;
use App\Domain\CredentialsManagement\Port\CredentialsWriter;
use App\Domain\CredentialsManagement\ValueObject\HashedPassword;

final class RegisterCredentialsHandler
{
    private $credentialsReader;
    private $credentialsWriter;

    public function __construct(CredentialsReader $credentialsReader, CredentialsWriter $credentialsWriter)
    {
        $this->credentialsReader = $credentialsReader;
        $this->credentialsWriter = $credentialsWriter;
    }

    /**
     * @throws credentialsManagementException
     * @throws \App\Infrastructure\Shared\Exception\InternalException
     */
    public function __invoke(RegisterCredentials $registercredentials)
    {
        if ($this->credentialsReader->isEmailAlreadyUsed($registercredentials->email())) {
            throw new CredentialsManagementException((string) ErrorMessage::EMAIL_ALREADY_USED());
        }


        $credentials = new Credentials(
            $registercredentials->credentialsId(),
            $registercredentials->email(),
            HashedPassword::fromPlainPassword($registercredentials->plainPassword())
        );

        $this->credentialsWriter->add($credentials);
    }
}
