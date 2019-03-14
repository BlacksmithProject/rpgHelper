<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement\Comand\PlayerRegistration;

use App\PlayerAccountManagement\Domain\Command\PlayerRegistration\RegisterAuthenticationToken;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\PlayerAccountManagement\Domain\ValueObject\TokenId;
use App\Tests\Domain\PlayerAccountManagement\BaseTestCase;

final class RegisterAuthenticationTokenTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $command = new RegisterAuthenticationToken($this->generateTokenId(), $this->generatePlayerId());

        $this->assertInstanceOf(TokenId::class, $command->tokenId());
        $this->assertInstanceOf(PlayerId::class, $command->playerId());
    }
}
