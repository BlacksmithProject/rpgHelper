<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Port;

use App\Domain\PlayerAccountManagement\Entity\Player;
use App\Domain\PlayerAccountManagement\ValueObject\Email;
use App\Domain\PlayerAccountManagement\ValueObject\PlayerId;
use App\Domain\PlayerAccountManagement\ValueObject\PlayerName;

interface PlayerReader
{
    public function isEmailAlreadyUsed(Email $email): bool;

    public function isNameAlreadyUsed(PlayerName $playerName): bool;

    public function get(PlayerId $playerId): Player;

    public function findWithEmail(Email $email): Player;
}
