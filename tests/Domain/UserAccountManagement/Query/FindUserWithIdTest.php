<?php
declare(strict_types=1);

namespace App\Tests\Domain\UserAccountManagement\Query;

use App\Domain\UserAccountManagement\Query\FindUserWithId;
use App\Tests\Domain\UserAccountManagement\BaseTestCase;

final class FindUserWithIdTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $query = new FindUserWithId($this->userReader);

        $this->userReader
            ->expects($this->once())
            ->method('get')
            ->willReturn($this->generateUser());

        $query($this->generateUserId());
    }
}
