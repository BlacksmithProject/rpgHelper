<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\Command\PlayerRegistration;

use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\PlayerAccountManagement\Domain\ValueObject\TokenId;

final class RegisterAuthenticationToken
{
    private $tokenId;
    private $playerId;

    public function __construct(TokenId $tokenId, PlayerId $playerId)
    {
        $this->tokenId = $tokenId;
        $this->playerId = $playerId;
    }

    public function tokenId(): TokenId
    {
        return $this->tokenId;
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
    }
}
