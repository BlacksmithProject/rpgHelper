<?php
declare(strict_types=1);

namespace App\Tests\Domain\UserAccountManagement\Query;

use App\Domain\UserAccountManagement\Query\FindUserWithEmail;
use App\Tests\Domain\UserAccountManagement\BaseTestCase;

final class FindUserWithEmailTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $query = new FindUserWithEmail($this->userReader);

        $this->userReader
            ->expects($this->once())
            ->method('findWithEmail')
            ->willReturn($this->generateUser());

        $query($this->generateEmail());
    }
}
