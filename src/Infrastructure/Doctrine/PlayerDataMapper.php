<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Application\Shared\Identity;
use App\Domain\GameManagement\Entity\Player;
use App\Domain\GameManagement\ValueObject\PlayerName;
use Ramsey\Uuid\Uuid;

final class PlayerDataMapper
{
    private $id;
    private $name;

    public function __construct(Player $player)
    {
        $this->id = Uuid::fromString((string) $player->id());
        $this->name = (string) $player->name();
    }

    public function toPlayer(): Player
    {
        return new Player(
            Identity::fromString($this->id->toString()),
            new PlayerName($this->name)
        );
    }
}
