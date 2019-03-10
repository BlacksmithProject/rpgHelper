<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Query;

use App\Domain\PlayerAccountManagement\Entity\Player;
use App\Domain\PlayerAccountManagement\Port\PlayerReader;
use App\Domain\PlayerAccountManagement\ValueObject\Email;

final class FindPlayerWithEmail
{
    private $playerReader;

    public function __construct(PlayerReader $playerReader)
    {
        $this->playerReader = $playerReader;
    }

    public function __invoke(Email $email): Player
    {
        return $this->playerReader->findWithEmail($email);
    }
}
