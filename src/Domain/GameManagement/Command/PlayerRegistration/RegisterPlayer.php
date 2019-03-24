<?php
declare(strict_types=1);

namespace App\Domain\GameManagement\Command\PlayerRegistration;

use App\Domain\GameManagement\ValueObject\PlayerId;
use App\Domain\GameManagement\ValueObject\PlayerName;

final class RegisterPlayer
{
    private $playerId;
    private $playerName;

    public function __construct(PlayerId $playerId, ?string $playerName)
    {
        $this->playerId = $playerId;
        $this->playerName = new PlayerName($playerName);
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
