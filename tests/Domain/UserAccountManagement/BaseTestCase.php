<?php
declare(strict_types=1);

namespace App\Tests\Domain\UserAccountManagement;

use App\Domain\UserAccountManagement\Command\UserRegistration\RegisterAuthenticationToken;
use App\Domain\UserAccountManagement\Command\UserRegistration\RegisterUser;
use App\Domain\UserAccountManagement\Entity\User;
use App\Domain\UserAccountManagement\Entity\Token;
use App\Domain\UserAccountManagement\Port\UserReader;
use App\Domain\UserAccountManagement\Port\UserWriter;
use App\Domain\UserAccountManagement\Port\TokenReader;
use App\Domain\UserAccountManagement\Port\TokenWriter;
use App\Domain\UserAccountManagement\ValueObject\Email;
use App\Domain\UserAccountManagement\ValueObject\HashedPassword;
use App\Domain\UserAccountManagement\ValueObject\PlainPassword;
use App\Domain\UserAccountManagement\ValueObject\UserId;
use App\Domain\UserAccountManagement\ValueObject\UserName;
use App\Domain\UserAccountManagement\ValueObject\TokenId;
use App\Domain\UserAccountManagement\ValueObject\TokenType;
use App\Domain\UserAccountManagement\ValueObject\TokenValue;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    /** @var UserReader|MockObject */
    protected $userReader;

    /** @var UserWriter|MockObject */
    protected $userWriter;

    /** @var TokenReader|MockObject */
    protected $tokenReader;

    /** @var TokenWriter|MockObject */
    protected $tokenWriter;

    protected function setUp()
    {
        $this->userReader = $this->createMock(UserReader::class);
        $this->userWriter = $this->createMock(UserWriter::class);
        $this->tokenReader = $this->createMock(TokenReader::class);
        $this->tokenWriter = $this->createMock(TokenWriter::class);
    }

    public function generateUserId(): UserId
    {
        /** @var UserId|MockObject $userId */
        $userId = $this->createMock(UserId::class);

        return $userId;
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

    public function generateUserName(string $name = 'White Wolf'): UserName
    {
        return new UserName($name);
    }

    public function generateUser(): User
    {
        return new User(
            $this->generateUserId(),
            $this->generateEmail(),
            $this->generateHashedPassword(),
            $this->generateUserName()
        );
    }

    public function generateToken(): Token
    {
        return Token::generate(
            $this->generateTokenId(),
            $this->generateUserId(),
            TokenValue::generate(),
            new \DateTimeImmutable(),
            TokenType::AUTHENTICATION()
        );
    }

    public function generateRegisterUserCommand(): RegisterUser
    {
        return new RegisterUser(
            $this->generateUserId(),
            'john.snow@winterfell.north',
            'winterIsComing',
            'White Wolf'
        );
    }

    public function generateRegisterAuthenticationTokenCommand(): RegisterAuthenticationToken
    {
        return new RegisterAuthenticationToken($this->generateTokenId(), $this->generateUserId());
    }
}
