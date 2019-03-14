<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain;

use App\PlayerAccountManagement\Domain\Command\PlayerRegistration\RegisterPlayer;
use App\PlayerAccountManagement\Domain\Command\PlayerRegistration\RegisterPlayerHandler;
use App\PlayerAccountManagement\Domain\Command\PlayerRegistration\RegisterAuthenticationToken;
use App\PlayerAccountManagement\Domain\Command\PlayerRegistration\RegisterAuthenticationTokenHandler;

final class PlayerCommandBus
{
    private $handlers;

    public function __construct(
        RegisterAuthenticationTokenHandler $registerTokenHandler,
        RegisterPlayerHandler $registerPlayerHandler
    ) {
        $this->handlers = [
            RegisterAuthenticationToken::class => $registerTokenHandler,
            RegisterPlayer::class => $registerPlayerHandler,
        ];
    }

    public function __invoke(object $command): void
    {
        ($this->handlers[get_class($command)])($command);
    }
}
