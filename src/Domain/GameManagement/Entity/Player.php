<?php
declare(strict_types=1);

namespace App\Domain\GameManagement\Entity;

use App\Domain\GameManagement\ValueObject\PlayerId;
use App\Domain\GameManagement\ValueObject\PlayerName;

final class Player
{
    private $id;
    private $name;

    public function __construct(PlayerId $playerId, PlayerName $playerName)
    {
        $this->id = $playerId;
        $this->name = $playerName;
    }

    public function id(): PlayerId
    {
        return $this->id;
    }

    public function name(): PlayerName
    {
        return $this->name;
    }
}
