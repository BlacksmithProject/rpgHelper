<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement\ValueObject;

use App\PlayerAccountManagement\Domain\ValueObject\PlayerName;
use App\Tests\Domain\PlayerAccountManagement\BaseTestCase;
use Assert\InvalidArgumentException;

final class PlayerNameTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $plainPassword = new PlayerName('White Wolf');

        $this->assertSame('White Wolf', (string) $plainPassword);
    }

    public function testItCannotHaveANullParameter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('player.name.cannot_be_null');

        new PlayerName(null);
    }

    public function testItCannotHaveABlankParameter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('player.name.cannot_be_blank');

        new PlayerName('');
    }
}
