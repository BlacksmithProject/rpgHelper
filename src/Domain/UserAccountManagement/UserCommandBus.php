<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement;

use App\Domain\UserAccountManagement\Command\UserRegistration\RegisterUser;
use App\Domain\UserAccountManagement\Command\UserRegistration\RegisterUserHandler;
use App\Domain\UserAccountManagement\Command\UserRegistration\RegisterAuthenticationToken;
use App\Domain\UserAccountManagement\Command\UserRegistration\RegisterAuthenticationTokenHandler;

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
