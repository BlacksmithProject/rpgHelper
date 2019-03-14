<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\Command\PlayerRegistration;

use App\PlayerAccountManagement\Domain\Entity\Token;
use App\PlayerAccountManagement\Domain\Port\TokenWriter;
use App\PlayerAccountManagement\Domain\ValueObject\TokenType;
use App\PlayerAccountManagement\Domain\ValueObject\TokenValue;
use App\Shared\Infrastructure\Exception\InternalException;

final class RegisterAuthenticationTokenHandler
{
    private $tokenWriter;

    public function __construct(TokenWriter $tokenWriter)
    {
        $this->tokenWriter = $tokenWriter;
    }

    /**
     * @throws \App\Shared\Infrastructure\Exception\InternalException
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
