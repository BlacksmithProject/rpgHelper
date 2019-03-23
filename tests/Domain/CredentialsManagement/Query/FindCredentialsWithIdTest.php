<?php
declare(strict_types=1);

namespace App\Tests\Domain\CredentialsManagement\Query;

use App\Domain\CredentialsManagement\Query\FindCredentialsWithId;
use App\Tests\Domain\CredentialsManagement\BaseTestCase;

final class FindCredentialsWithIdTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $query = new FindCredentialsWithId($this->credentialsReader);

        $this->credentialsReader
            ->expects($this->once())
            ->method('get')
            ->willReturn($this->generateCredentials());

        $query($this->generateCredentialsId());
    }
}
