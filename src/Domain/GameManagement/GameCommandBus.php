<?php
declare(strict_types=1);

namespace App\Domain\GameManagement;

use App\Domain\GameManagement\Command\PlayerRegistration\RegisterPlayer;
use App\Domain\GameManagement\Command\PlayerRegistration\RegisterPlayerHandler;

final class GameCommandBus
{
    private $handlers;

    public function __construct(
        RegisterPlayerHandler $registerPlayerHandler
    ) {
        $this->handlers = [
            RegisterPlayer::class => $registerPlayerHandler,
        ];
    }

    public function __invoke(object $command)
    {
        ($this->handlers[get_class($command)])($command);
    }
}
