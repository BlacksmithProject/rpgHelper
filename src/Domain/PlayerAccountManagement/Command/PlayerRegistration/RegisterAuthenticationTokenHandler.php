<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Command\PlayerRegistration;

use App\Domain\PlayerAccountManagement\Entity\Token;
use App\Domain\PlayerAccountManagement\Port\TokenWriter;
use App\Domain\PlayerAccountManagement\ValueObject\TokenType;
use App\Domain\PlayerAccountManagement\ValueObject\TokenValue;
use App\Infrastructure\Exception\InternalException;

final class RegisterAuthenticationTokenHandler
{
    private $tokenWriter;

    public function __construct(TokenWriter $tokenWriter)
    {
        $this->tokenWriter = $tokenWriter;
    }

    /**
     * @throws \App\Infrastructure\Exception\InternalException
     */
    public function __invoke(RegisterAuthenticationToken $registerToken)
    {
        try {
            $token = Token::generate(
                $registerToken->tokenId(),
                $registerToken->playerId(),
                TokenValue::generate(),
                new \DateTimeImmutable(),
                TokenType::AUTHENTICATION()
            );
        } catch (\Exception $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        $this->tokenWriter->add($token);
    }
}
