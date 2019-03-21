<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\Command\UserRegistration;

use App\UserAccountManagement\Domain\Entity\Token;
use App\UserAccountManagement\Domain\Port\TokenWriter;
use App\UserAccountManagement\Domain\ValueObject\TokenType;
use App\UserAccountManagement\Domain\ValueObject\TokenValue;
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
