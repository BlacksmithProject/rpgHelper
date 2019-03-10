<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Query;

use App\Domain\PlayerAccountManagement\Entity\Token;
use App\Domain\PlayerAccountManagement\Port\TokenReader;
use App\Domain\PlayerAccountManagement\ValueObject\PlayerId;
use App\Domain\PlayerAccountManagement\ValueObject\TokenType;

final class FindTokenWithPlayerIdAndType
{
    private $tokenReader;

    public function __construct(TokenReader $tokenReader)
    {
        $this->tokenReader = $tokenReader;
    }

    public function __invoke(PlayerId $playerId, TokenType $tokenType): Token
    {
        return $this->tokenReader->findWithPlayerIdAndType($playerId, $tokenType);
    }
}
