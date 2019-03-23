<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\Command\UserRegistration;

use App\Domain\UserAccountManagement\Entity\Token;
use App\Domain\UserAccountManagement\Port\TokenWriter;
use App\Domain\UserAccountManagement\ValueObject\TokenType;
use App\Domain\UserAccountManagement\ValueObject\TokenValue;
use App\Infrastructure\Shared\Exception\InternalException;

final class RegisterAuthenticationTokenHandler
{
    private $tokenWriter;

    public function __construct(TokenWriter $tokenWriter)
    {
        $this->tokenWriter = $tokenWriter;
    }

    /**
     * @throws \App\Infrastructure\Shared\Exception\InternalException
     */
    public function __invoke(RegisterAuthenticationToken $registerToken)
    {
        try {
            $token = Token::generate(
                $registerToken->tokenId(),
                $registerToken->userId(),
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
