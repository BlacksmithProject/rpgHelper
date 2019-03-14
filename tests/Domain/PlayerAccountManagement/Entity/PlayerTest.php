<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement\Entity;

use App\PlayerAccountManagement\Domain\Entity\Player;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\Tests\Domain\PlayerAccountManagement\BaseTestCase;

final class PlayerTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $player = new Player(
            $this->generatePlayerId(),
            $this->generateEmail(),
            $this->generateHashedPassword(),
            $this->generatePlayerName()
        );

        $this->assertInstanceOf(PlayerId::class, $player->id());
        $this->assertSame('john.snow@winterfell.north', (string) $player->email());
        $this->assertTrue($player->hashedPassword()->isSameThan($this->generatePlainPassword()));
        $this->assertSame('White Wolf', (string) $player->name());
    }
}
