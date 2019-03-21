<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain;

use App\UserAccountManagement\Domain\Command\UserRegistration\RegisterUser;
use App\UserAccountManagement\Domain\Command\UserRegistration\RegisterUserHandler;
use App\UserAccountManagement\Domain\Command\UserRegistration\RegisterAuthenticationToken;
use App\UserAccountManagement\Domain\Command\UserRegistration\RegisterAuthenticationTokenHandler;

final class UserCommandBus
{
    private $handlers;

    public function __construct(
        RegisterAuthenticationTokenHandler $registerTokenHandler,
        RegisterUserHandler $registerUserHandler
    ) {
        $this->handlers = [
            RegisterAuthenticationToken::class => $registerTokenHandler,
            RegisterUser::class => $registerUserHandler,
        ];
    }

    public function __invoke(object $command): void
    {
        ($this->handlers[get_class($command)])($command);
    }
}
