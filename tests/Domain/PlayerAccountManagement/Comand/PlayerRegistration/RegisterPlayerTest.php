<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement\Comand\PlayerRegistration;

use App\PlayerAccountManagement\Domain\Command\PlayerRegistration\RegisterPlayer;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\Tests\Domain\PlayerAccountManagement\BaseTestCase;

final class RegisterPlayerTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $command = new RegisterPlayer(
            $this->generatePlayerId(),
            'john.snow@winterfell.north',
            'winterIsComing',
            'White Wolf'
        );

        $this->assertInstanceOf(PlayerId::class, $command->playerId());
        $this->assertSame('john.snow@winterfell.north', (string) $command->email());
        $this->assertSame('winterIsComing', (string) $command->plainPassword());
        $this->assertSame('White Wolf', (string) $command->playerName());
    }
}
