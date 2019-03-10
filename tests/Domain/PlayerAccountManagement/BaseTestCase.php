<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement;

use App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterAuthenticationToken;
use App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterPlayer;
use App\Domain\PlayerAccountManagement\Entity\Player;
use App\Domain\PlayerAccountManagement\Entity\Token;
use App\Domain\PlayerAccountManagement\Port\PlayerReader;
use App\Domain\PlayerAccountManagement\Port\PlayerWriter;
use App\Domain\PlayerAccountManagement\Port\TokenReader;
use App\Domain\PlayerAccountManagement\Port\TokenWriter;
use App\Domain\PlayerAccountManagement\ValueObject\Email;
use App\Domain\PlayerAccountManagement\ValueObject\HashedPassword;
use App\Domain\PlayerAccountManagement\ValueObject\PlainPassword;
use App\Domain\PlayerAccountManagement\ValueObject\PlayerId;
use App\Domain\PlayerAccountManagement\ValueObject\PlayerName;
use App\Domain\PlayerAccountManagement\ValueObject\TokenId;
use App\Domain\PlayerAccountManagement\ValueObject\TokenType;
use App\Domain\PlayerAccountManagement\ValueObject\TokenValue;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    /** @var PlayerReader|MockObject */
    protected $playerReader;

    /** @var PlayerWriter|MockObject */
    protected $playerWriter;

    /** @var TokenReader|MockObject */
    protected $tokenReader;

    /** @var TokenWriter|MockObject */
    protected $tokenWriter;

    protected function setUp()
    {
        $this->playerReader = $this->createMock(PlayerReader::class);
        $this->playerWriter = $this->createMock(PlayerWriter::class);
        $this->tokenReader = $this->createMock(TokenReader::class);
        $this->tokenWriter = $this->createMock(TokenWriter::class);
    }

    public function generatePlayerId(): PlayerId
    {
        /** @var PlayerId|MockObject $playerId */
        $playerId = $this->createMock(PlayerId::class);

        return $playerId;
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

    public function generatePlayerName(string $name = 'White Wolf'): PlayerName
    {
        return new PlayerName($name);
    }

    public function generatePlayer(): Player
    {
        return new Player(
            $this->generatePlayerId(),
            $this->generateEmail(),
            $this->generateHashedPassword(),
            $this->generatePlayerName()
        );
    }

    public function generateToken(): Token
    {
        return Token::generate(
            $this->generateTokenId(),
            $this->generatePlayerId(),
            TokenValue::generate(),
            new \DateTimeImmutable(),
            TokenType::AUTHENTICATION()
        );
    }

    public function generateRegisterPlayerCommand(): RegisterPlayer
    {
        return new RegisterPlayer(
            $this->generatePlayerId(),
            'john.snow@winterfell.north',
            'winterIsComing',
            'White Wolf'
        );
    }

    public function generateRegisterAuthenticationTokenCommand(): RegisterAuthenticationToken
    {
        return new RegisterAuthenticationToken($this->generateTokenId(), $this->generatePlayerId());
    }
}
