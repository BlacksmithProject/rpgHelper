<?php
declare(strict_types=1);

namespace App\Domain\GameManagement\Query;

use App\Domain\GameManagement\Entity\Player;
use App\Domain\GameManagement\Port\PlayerReader;
use App\Domain\GameManagement\ValueObject\PlayerId;

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
