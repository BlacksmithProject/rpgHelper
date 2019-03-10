<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Query;

use App\Domain\PlayerAccountManagement\Entity\Player;
use App\Domain\PlayerAccountManagement\Port\PlayerReader;
use App\Domain\PlayerAccountManagement\ValueObject\PlayerId;

final class FindPlayerWithId
{
    private $playerReader;

    public function __construct(PlayerReader $playerReader)
    {
        $this->playerReader = $playerReader;
    }

    public function __invoke(PlayerId $playerId): Player
    {
        return $this->playerReader->get($playerId);
    }
}
