<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement;

use App\PlayerAccountManagement\Domain\Command\PlayerRegistration\RegisterAuthenticationToken;
use App\PlayerAccountManagement\Domain\Command\PlayerRegistration\RegisterPlayer;
use App\PlayerAccountManagement\Domain\Entity\Player;
use App\PlayerAccountManagement\Domain\Entity\Token;
use App\PlayerAccountManagement\Domain\Port\PlayerReader;
use App\PlayerAccountManagement\Domain\Port\PlayerWriter;
use App\PlayerAccountManagement\Domain\Port\TokenReader;
use App\PlayerAccountManagement\Domain\Port\TokenWriter;
use App\PlayerAccountManagement\Domain\ValueObject\Email;
use App\PlayerAccountManagement\Domain\ValueObject\HashedPassword;
use App\PlayerAccountManagement\Domain\ValueObject\PlainPassword;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerName;
use App\PlayerAccountManagement\Domain\ValueObject\TokenId;
use App\PlayerAccountManagement\Domain\ValueObject\TokenType;
use App\PlayerAccountManagement\Domain\ValueObject\TokenValue;
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
