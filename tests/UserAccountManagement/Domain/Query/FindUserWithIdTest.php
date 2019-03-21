<?php
declare(strict_types=1);

namespace App\Tests\UserAccountManagement\Domain\Query;

use App\UserAccountManagement\Domain\Query\FindUserWithId;
use App\Tests\UserAccountManagement\Domain\BaseTestCase;

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
