<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\Port;

use App\PlayerAccountManagement\Domain\Entity\Player;
use App\PlayerAccountManagement\Domain\ValueObject\Email;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerName;

interface PlayerReader
{
    public function isEmailAlreadyUsed(Email $email): bool;

    public function isNameAlreadyUsed(PlayerName $playerName): bool;

    public function get(PlayerId $playerId): Player;

    public function findWithEmail(Email $email): Player;
}
