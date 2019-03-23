<?php
declare(strict_types=1);

namespace App\Tests\Domain\CredentialsManagement;

use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterAuthenticationToken;
use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterCredentials;
use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\Entity\Token;
use App\Domain\CredentialsManagement\Port\CredentialsReader;
use App\Domain\CredentialsManagement\Port\CredentialsWriter;
use App\Domain\CredentialsManagement\Port\TokenReader;
use App\Domain\CredentialsManagement\Port\TokenWriter;
use App\Domain\CredentialsManagement\ValueObject\Email;
use App\Domain\CredentialsManagement\ValueObject\HashedPassword;
use App\Domain\CredentialsManagement\ValueObject\PlainPassword;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;
use App\Domain\CredentialsManagement\ValueObject\TokenId;
use App\Domain\CredentialsManagement\ValueObject\TokenType;
use App\Domain\CredentialsManagement\ValueObject\TokenValue;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    /** @var CredentialsReader|MockObject */
    protected $credentialsReader;

    /** @var CredentialsWriter|MockObject */
    protected $credentialsWriter;

    /** @var TokenReader|MockObject */
    protected $tokenReader;

    /** @var TokenWriter|MockObject */
    protected $tokenWriter;

    protected function setUp()
    {
        $this->credentialsReader = $this->createMock(CredentialsReader::class);
        $this->credentialsWriter = $this->createMock(CredentialsWriter::class);
        $this->tokenReader = $this->createMock(TokenReader::class);
        $this->tokenWriter = $this->createMock(TokenWriter::class);
    }

    public function generateCredentialsId(): CredentialsId
    {
        /** @var CredentialsId|MockObject $credentialsId */
        $credentialsId = $this->createMock(CredentialsId::class);

        return $credentialsId;
    }

    public function generateTokenId(): TokenId
    {
        /** @var TokenId|MockObject $tokenId */
        $tokenId = $this->createMock(TokenId::class);

        return $tokenId;
    }

    public function generateEmail(string $email = 'john.snow@winterfell.north'): Email
    {
        return new Email($email);
    }

    public function generatePlainPassword(string $password = 'winterIsComing'): PlainPassword
    {
        return new PlainPassword($password);
    }

    public function generateHashedPassword(PlainPassword $plainPassword = null, string $hash = null): HashedPassword
    {
        if (null !== $plainPassword) {
            return HashedPassword::fromPlainPassword($plainPassword);
        }

        if (null !== $hash) {
            return HashedPassword::fromHash($hash);
        }

        return HashedPassword::fromPlainPassword($this->generatePlainPassword());
    }

    public function generateCredentials(): Credentials
    {
        return new Credentials(
            $this->generateCredentialsId(),
            $this->generateEmail(),
            $this->generateHashedPassword()
        );
    }

    public function generateToken(): Token
    {
        return Token::generate(
            $this->generateTokenId(),
            $this->generateCredentialsId(),
            TokenValue::generate(),
            new \DateTimeImmutable(),
            TokenType::AUTHENTICATION()
        );
    }

    public function generateRegisterCredentialsCommand(): RegisterCredentials
    {
        return new RegisterCredentials(
            $this->generateCredentialsId(),
            'john.snow@winterfell.north',
            'winterIsComing'
        );
    }

    public function generateRegisterAuthenticationTokenCommand(): RegisterAuthenticationToken
    {
        return new RegisterAuthenticationToken($this->generateTokenId(), $this->generateCredentialsId());
    }
}
