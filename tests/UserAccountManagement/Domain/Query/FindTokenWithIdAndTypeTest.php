<?php
declare(strict_types=1);

namespace App\Tests\UserAccountManagement\Domain\Query;

use App\UserAccountManagement\Domain\Query\FindTokenWithUserIdAndType;
use App\UserAccountManagement\Domain\ValueObject\TokenType;
use App\Tests\UserAccountManagement\Domain\BaseTestCase;

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
