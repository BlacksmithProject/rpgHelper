<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\Port;

use App\PlayerAccountManagement\Domain\Entity\Token;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\PlayerAccountManagement\Domain\ValueObject\TokenId;
use App\PlayerAccountManagement\Domain\ValueObject\TokenType;

interface TokenReader
{
    public function get(TokenId $tokenId): Token;

    public function findWithPlayerIdAndType(PlayerId $playerId, TokenType $tokenType): Token;
}
