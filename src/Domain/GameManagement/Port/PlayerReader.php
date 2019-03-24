<?php
declare(strict_types=1);

namespace App\Domain\GameManagement\Port;

use App\Domain\GameManagement\ValueObject\PlayerName;

interface PlayerReader
{
    public function isNameAlreadyUsed(PlayerName $playerName): bool;
}