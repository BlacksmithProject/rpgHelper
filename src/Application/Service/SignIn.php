<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Shared\Exception\ApplicationException;
use App\Application\Model\AuthenticatedPlayer;
use App\Application\Shared\Identity;
use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\Entity\Token;
use App\Domain\CredentialsManagement\Query\FindCredentialsWithEmail;
use App\Domain\CredentialsManagement\Query\FindTokenWithCredentialsIdAndType;
use App\Domain\CredentialsManagement\ValueObject\Email;
use App\Domain\CredentialsManagement\ValueObject\PlainPassword;
use App\Domain\CredentialsManagement\ValueObject\TokenType;
use App\Domain\GameManagement\Query\FindPlayerWithId;

final class SignIn
{
    private $findCredentialsWithEmail;
    private $findTokenWithCredentialsIdAndType;
    private $findPlayerWithId;

    public function __construct(
        FindCredentialsWithEmail $findCredentialsWithEmail,
        FindTokenWithCredentialsIdAndType $findTokenWithCredentialsIdAndType,
        FindPlayerWithId $findPlayerWithId
    ) {
        $this->findCredentialsWithEmail = $findCredentialsWithEmail;
        $this->findTokenWithCredentialsIdAndType = $findTokenWithCredentialsIdAndType;
        $this->findPlayerWithId = $findPlayerWithId;
    }

    /**
     * @throws ApplicationException
     */
    public function __invoke(?string $email, ?string $password): AuthenticatedPlayer
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

        $player = ($this->findPlayerWithId)(Identity::fromString((string) $credentials->id()));

        return new AuthenticatedPlayer($credentials, $token, $player);
    }
}
