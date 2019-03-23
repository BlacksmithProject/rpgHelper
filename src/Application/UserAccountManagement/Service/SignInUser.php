<?php
declare(strict_types=1);

namespace App\Application\UserAccountManagement\Service;

use App\Application\Shared\Exception\ApplicationException;
use App\Application\UserAccountManagement\Model\AuthenticatedUser;
use App\Domain\UserAccountManagement\Entity\User;
use App\Domain\UserAccountManagement\Entity\Token;
use App\Domain\UserAccountManagement\Query\FindUserWithEmail;
use App\Domain\UserAccountManagement\Query\FindTokenWithUserIdAndType;
use App\Domain\UserAccountManagement\ValueObject\Email;
use App\Domain\UserAccountManagement\ValueObject\PlainPassword;
use App\Domain\UserAccountManagement\ValueObject\TokenType;

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
