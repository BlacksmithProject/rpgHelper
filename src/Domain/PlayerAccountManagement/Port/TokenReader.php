<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Port;

use App\Domain\PlayerAccountManagement\Entity\Token;
use App\Domain\PlayerAccountManagement\ValueObject\PlayerId;
use App\Domain\PlayerAccountManagement\ValueObject\TokenId;
use App\Domain\PlayerAccountManagement\ValueObject\TokenType;

interface TokenReader
{
    public function get(TokenId $tokenId): Token;

    public function findWithPlayerIdAndType(PlayerId $playerId, TokenType $tokenType): Token;
}
