<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\Command\CredentialsRegistration;

use App\Domain\CredentialsManagement\Entity\Token;
use App\Domain\CredentialsManagement\Port\TokenWriter;
use App\Domain\CredentialsManagement\ValueObject\TokenType;
use App\Domain\CredentialsManagement\ValueObject\TokenValue;
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
                $registerToken->credentialsId(),
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
