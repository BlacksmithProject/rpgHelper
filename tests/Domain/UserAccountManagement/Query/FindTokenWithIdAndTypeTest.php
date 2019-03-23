<?php
declare(strict_types=1);

namespace App\Tests\Domain\UserAccountManagement\Query;

use App\Domain\UserAccountManagement\Query\FindTokenWithUserIdAndType;
use App\Domain\UserAccountManagement\ValueObject\TokenType;
use App\Tests\Domain\UserAccountManagement\BaseTestCase;

final class FindTokenWithIdAndTypeTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $query = new FindTokenWithUserIdAndType($this->tokenReader);

        $this->tokenReader
            ->expects($this->once())
            ->method('findWithUserIdAndType')
            ->willReturn($this->generateToken());

        $query($this->generateUserId(), TokenType::AUTHENTICATION());
    }
}
