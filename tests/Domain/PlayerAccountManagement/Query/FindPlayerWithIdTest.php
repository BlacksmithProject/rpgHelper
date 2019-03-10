<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement\Query;

use App\Domain\PlayerAccountManagement\Query\FindPlayerWithId;
use App\Tests\Domain\PlayerAccountManagement\BaseTestCase;

final class FindPlayerWithIdTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $query = new FindPlayerWithId($this->playerReader);

        $this->playerReader
            ->expects($this->once())
            ->method('get')
            ->willReturn($this->generatePlayer());

        $query($this->generatePlayerId());
    }
}
