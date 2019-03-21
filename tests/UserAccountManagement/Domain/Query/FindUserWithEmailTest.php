<?php
declare(strict_types=1);

namespace App\Tests\UserAccountManagement\Domain\Query;

use App\UserAccountManagement\Domain\Query\FindUserWithEmail;
use App\Tests\UserAccountManagement\Domain\BaseTestCase;

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
