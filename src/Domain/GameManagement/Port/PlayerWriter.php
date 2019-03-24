<?php
declare(strict_types=1);

namespace App\Domain\GameManagement\Port;

use App\Domain\GameManagement\Entity\Player;

interface PlayerWriter
{
    public function add(Player $player): void;
}
