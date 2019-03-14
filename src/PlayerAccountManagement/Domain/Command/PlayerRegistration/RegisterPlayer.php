<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\Command\PlayerRegistration;

use App\PlayerAccountManagement\Domain\ValueObject\Email;
use App\PlayerAccountManagement\Domain\ValueObject\PlainPassword;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerName;

final class RegisterPlayer
{
    private $playerId;
    private $email;
    private $plainPassword;
    private $playerName;

    public function __construct(
        PlayerId $playerId,
        ?string $email,
        ?string $plainPassword,
        ?string $playerName
    ) {
        $this->playerId = $playerId;
        $this->email = new Email($email);
        $this->plainPassword = new PlainPassword($plainPassword);
        $this->playerName = new PlayerName($playerName);
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function plainPassword(): PlainPassword
    {
        return $this->plainPassword;
    }

    public function playerName(): PlayerName
    {
        return $this->playerName;
    }
}
