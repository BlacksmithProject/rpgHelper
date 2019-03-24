<?php
declare(strict_types=1);

namespace App\Domain\GameManagement\Port;

use App\Domain\GameManagement\Entity\Player;
use App\Domain\GameManagement\ValueObject\PlayerId;
use App\Domain\GameManagement\ValueObject\PlayerName;

interface PlayerReader
{
    public function isNameAlreadyUsed(PlayerName $playerName): bool;

    public function get(PlayerId $playerId): Player;
}
