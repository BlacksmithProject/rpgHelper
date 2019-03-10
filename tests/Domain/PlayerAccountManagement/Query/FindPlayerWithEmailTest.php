<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement\Query;

use App\Domain\PlayerAccountManagement\Query\FindPlayerWithEmail;
use App\Tests\Domain\PlayerAccountManagement\BaseTestCase;

final class FindPlayerWithEmailTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $query = new FindPlayerWithEmail($this->playerReader);

        $this->playerReader
            ->expects($this->once())
            ->method('findWithEmail')
            ->willReturn($this->generatePlayer());

        $query($this->generateEmail());
    }
}
