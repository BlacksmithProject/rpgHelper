<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Shared\Exception\ApplicationException;
use App\Application\Model\AuthenticatedCredentials;
use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\Entity\Token;
use App\Domain\CredentialsManagement\Query\FindCredentialsWithEmail;
use App\Domain\CredentialsManagement\Query\FindTokenWithCredentialsIdAndType;
use App\Domain\CredentialsManagement\ValueObject\Email;
use App\Domain\CredentialsManagement\ValueObject\PlainPassword;
use App\Domain\CredentialsManagement\ValueObject\TokenType;

final class SignInCredentials
{
    private $findCredentialsWithEmail;
    private $findTokenWithCredentialsIdAndType;

    public function __construct(
        FindCredentialsWithEmail $findCredentialsWithEmail,
        FindTokenWithCredentialsIdAndType $findTokenWithCredentialsIdAndType
    ) {
        $this->findCredentialsWithEmail = $findCredentialsWithEmail;
        $this->findTokenWithCredentialsIdAndType = $findTokenWithCredentialsIdAndType;
    }

    /**
     * @throws ApplicationException
     */
    public function __invoke(?string $email, ?string $password): AuthenticatedCredentials
    {
        $email = new Email($email);
        $plainPassword = new PlainPassword($password);

        /** @var Credentials $credentials */
        $credentials = ($this->findCredentialsWithEmail)($email);

        if (!$credentials->hashedPassword()->isSameThan($plainPassword)) {
            throw new ApplicationException();
        }

        /** @var Token $token */
        $token = ($this->findTokenWithCredentialsIdAndType)($credentials->id(), TokenType::AUTHENTICATION());

        return new AuthenticatedCredentials($credentials, $token);
    }
}
