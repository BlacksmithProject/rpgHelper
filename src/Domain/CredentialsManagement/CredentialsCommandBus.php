<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement;

use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterCredentials;
use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterCredentialsHandler;
use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterAuthenticationToken;
use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterAuthenticationTokenHandler;

final class CredentialsCommandBus
{
    private $handlers;

    public function __construct(
        RegisterAuthenticationTokenHandler $registerTokenHandler,
        RegisterCredentialsHandler $registerCredentialsHandler
    ) {
        $this->handlers = [
            RegisterAuthenticationToken::class => $registerTokenHandler,
            RegisterCredentials::class => $registerCredentialsHandler,
        ];
    }

    public function __invoke(object $command): void
    {
        ($this->handlers[get_class($command)])($command);
    }
}
