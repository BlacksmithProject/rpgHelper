<?php
declare(strict_types=1);

namespace App\Domain\GameManagement\Command\PlayerRegistration;

use App\Domain\GameManagement\Entity\Player;
use App\Domain\GameManagement\ErrorMessage;
use App\Domain\GameManagement\GameManagementException;
use App\Domain\GameManagement\Port\PlayerReader;
use App\Domain\GameManagement\Port\PlayerWriter;

final class RegisterPlayerHandler
{
    private $playerReader;
    private $playerWriter;

    public function __construct(PlayerReader $playerReader, PlayerWriter $playerWriter)
    {
        $this->playerReader = $playerReader;
        $this->playerWriter = $playerWriter;
    }

    /**
     * @throws GameManagementException
     */
    public function __invoke(RegisterPlayer $registerPlayer)
    {
        if ($this->playerReader->isNameAlreadyUsed($registerPlayer->playerName())) {
            throw new GameManagementException((string) ErrorMessage::PLAYER_NAME_ALREADY_USED());
        }

        $player = new Player($registerPlayer->playerId(), $registerPlayer->playerName());

        $this->playerWriter->add($player);
    }
}
