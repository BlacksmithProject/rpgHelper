<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\Port;

use App\PlayerAccountManagement\Domain\Entity\Player;

interface PlayerWriter
{
    public function add(Player $player): void;
}
