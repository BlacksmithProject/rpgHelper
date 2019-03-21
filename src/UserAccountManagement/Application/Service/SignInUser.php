<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Application\Service;

use App\Shared\Application\Exception\ApplicationException;
use App\UserAccountManagement\Application\Model\AuthenticatedUser;
use App\UserAccountManagement\Domain\Entity\User;
use App\UserAccountManagement\Domain\Entity\Token;
use App\UserAccountManagement\Domain\Query\FindUserWithEmail;
use App\UserAccountManagement\Domain\Query\FindTokenWithUserIdAndType;
use App\UserAccountManagement\Domain\ValueObject\Email;
use App\UserAccountManagement\Domain\ValueObject\PlainPassword;
use App\UserAccountManagement\Domain\ValueObject\TokenType;

final class SignInUser
{
    private $findUserWithEmail;
    private $findTokenWithUserIdAndType;

    public function __construct(
        FindUserWithEmail $findUserWithEmail,
        FindTokenWithUserIdAndType $findTokenWithUserIdAndType
    ) {
        $this->findUserWithEmail = $findUserWithEmail;
        $this->findTokenWithUserIdAndType = $findTokenWithUserIdAndType;
    }

    /**
     * @throws ApplicationException
     */
    public function __invoke(?string $email, ?string $password): AuthenticatedUser
    {
        $email = new Email($email);
        $plainPassword = new PlainPassword($password);

        /** @var User $user */
        $user = ($this->findUserWithEmail)($email);

        if (!$user->hashedPassword()->isSameThan($plainPassword)) {
            throw new ApplicationException();
        }

        /** @var Token $token */
        $token = ($this->findTokenWithUserIdAndType)($user->id(), TokenType::AUTHENTICATION());

        return new AuthenticatedUser($user, $token);
    }
}
