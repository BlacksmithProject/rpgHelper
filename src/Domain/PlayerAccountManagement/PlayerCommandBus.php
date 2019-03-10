<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement;

use App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterPlayer;
use App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterPlayerHandler;
use App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterAuthenticationToken;
use App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterAuthenticationTokenHandler;

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
