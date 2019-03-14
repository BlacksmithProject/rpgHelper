<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\Entity;

use App\PlayerAccountManagement\Domain\ValueObject\Email;
use App\PlayerAccountManagement\Domain\ValueObject\HashedPassword;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerName;

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
