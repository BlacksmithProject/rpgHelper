<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement\Query;

use App\Domain\PlayerAccountManagement\Query\FindTokenWithPlayerIdAndType;
use App\Domain\PlayerAccountManagement\ValueObject\TokenType;
use App\Tests\Domain\PlayerAccountManagement\BaseTestCase;

final class FindTokenWithIdAndTypeTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $query = new FindTokenWithPlayerIdAndType($this->tokenReader);

        $this->tokenReader
            ->expects($this->once())
            ->method('findWithPlayerIdAndType')
            ->willReturn($this->generateToken());

        $query($this->generatePlayerId(), TokenType::AUTHENTICATION());
    }
}
