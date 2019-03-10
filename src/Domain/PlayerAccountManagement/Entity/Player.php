<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Entity;

use App\Domain\PlayerAccountManagement\ValueObject\Email;
use App\Domain\PlayerAccountManagement\ValueObject\HashedPassword;
use App\Domain\PlayerAccountManagement\ValueObject\PlayerId;
use App\Domain\PlayerAccountManagement\ValueObject\PlayerName;

final class Player
{
    private $id;
    private $email;
    private $hashedPassword;
    private $name;

    public function __construct(
        PlayerId $playerId,
        Email $email,
        HashedPassword $hashedPassword,
        PlayerName $playerName
    ) {
        $this->id = $playerId;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->name = $playerName;
    }

    public function id(): PlayerId
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

    public function name(): PlayerName
    {
        return $this->name;
    }
}
