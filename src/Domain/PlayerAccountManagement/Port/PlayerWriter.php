<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Port;

use App\Domain\PlayerAccountManagement\Entity\Player;

interface PlayerWriter
{
    public function add(Player $player): void;
}
