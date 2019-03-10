<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Command\PlayerRegistration;

use App\Domain\PlayerAccountManagement\ValueObject\PlayerId;
use App\Domain\PlayerAccountManagement\ValueObject\TokenId;

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
