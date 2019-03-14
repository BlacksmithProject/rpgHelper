<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\Query;

use App\PlayerAccountManagement\Domain\Entity\Player;
use App\PlayerAccountManagement\Domain\Port\PlayerReader;
use App\PlayerAccountManagement\Domain\ValueObject\Email;

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
