<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Player;

use App\Domain\PlayerAccountManagement\Entity\Player;
use App\Domain\PlayerAccountManagement\ValueObject\Email;
use App\Domain\PlayerAccountManagement\ValueObject\HashedPassword;
use App\Domain\PlayerAccountManagement\ValueObject\PlayerName;
use App\Application\Shared\Identity;
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
