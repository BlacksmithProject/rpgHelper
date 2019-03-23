<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\Command\UserRegistration;

use App\Domain\UserAccountManagement\Entity\User;
use App\Domain\UserAccountManagement\ErrorMessage;
use App\Domain\UserAccountManagement\UserAccountManagementException;
use App\Domain\UserAccountManagement\Port\UserReader;
use App\Domain\UserAccountManagement\Port\UserWriter;
use App\Domain\UserAccountManagement\ValueObject\HashedPassword;

final class RegisterUserHandler
{
    private $userReader;
    private $userWriter;

    public function __construct(UserReader $userReader, UserWriter $userWriter)
    {
        $this->userReader = $userReader;
        $this->userWriter = $userWriter;
    }

    /**
     * @throws UserAccountManagementException
     * @throws \App\Infrastructure\Shared\Exception\InternalException
     */
    public function __invoke(RegisterUser $registerUser)
    {
        if ($this->userReader->isEmailAlreadyUsed($registerUser->email())) {
            throw new UserAccountManagementException((string) ErrorMessage::EMAIL_ALREADY_USED());
        }

        if ($this->userReader->isNameAlreadyUsed($registerUser->userName())) {
            throw new UserAccountManagementException((string) ErrorMessage::NAME_ALREADY_USED());
        }

        $user = new User(
            $registerUser->userId(),
            $registerUser->email(),
            HashedPassword::fromPlainPassword($registerUser->plainPassword()),
            $registerUser->userName()
        );

        $this->userWriter->add($user);
    }
}
