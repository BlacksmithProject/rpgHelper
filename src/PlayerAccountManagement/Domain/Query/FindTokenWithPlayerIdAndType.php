<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\Query;

use App\PlayerAccountManagement\Domain\Entity\Token;
use App\PlayerAccountManagement\Domain\Port\TokenReader;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\PlayerAccountManagement\Domain\ValueObject\TokenType;

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
