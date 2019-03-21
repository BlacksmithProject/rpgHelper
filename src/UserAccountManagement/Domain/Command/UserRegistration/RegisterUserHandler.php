<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\Command\UserRegistration;

use App\UserAccountManagement\Domain\Entity\User;
use App\UserAccountManagement\Domain\ErrorMessage;
use App\UserAccountManagement\Domain\UserAccountManagementException;
use App\UserAccountManagement\Domain\Port\UserReader;
use App\UserAccountManagement\Domain\Port\UserWriter;
use App\UserAccountManagement\Domain\ValueObject\HashedPassword;

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
     * @throws \App\Shared\Infrastructure\Exception\InternalException
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
