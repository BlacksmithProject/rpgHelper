<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Infrastructure\Doctrine;

use App\PlayerAccountManagement\Domain\Entity\Player;
use App\PlayerAccountManagement\Domain\ValueObject\Email;
use App\PlayerAccountManagement\Domain\ValueObject\HashedPassword;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerName;
use App\Shared\Application\Identity;
use Ramsey\Uuid\Uuid;

final class PlayerDataMapper
{
    private $id;
    private $email;
    private $hashedPassword;
    private $name;

    public function __construct(Player $player)
    {
        $this->id = Uuid::fromString((string) $player->id());
        $this->email = (string) $player->email();
        $this->hashedPassword = (string) $player->hashedPassword();
        $this->name = (string) $player->name();
    }

    public function toPlayer(): Player
    {
        return new Player(
            Identity::fromString($this->id->toString()),
            new Email($this->email),
            HashedPassword::fromHash($this->hashedPassword),
            new PlayerName($this->name)
        );
    }
}
