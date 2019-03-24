<?php
declare(strict_types=1);

namespace App\Domain\GameManagement\Entity;

use App\Domain\GameManagement\ValueObject\PlayerId;
use App\Domain\GameManagement\ValueObject\PlayerName;

final class Player
{
    private $playerId;
    private $playerName;

    public function __construct(PlayerId $playerId, PlayerName $playerName)
    {
        $this->playerId = $playerId;
        $this->playerName = $playerName;
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
    }

    public function playerName(): PlayerName
    {
        return $this->playerName;
    }
}
