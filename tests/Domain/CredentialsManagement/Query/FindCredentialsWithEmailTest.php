<?php
declare(strict_types=1);

namespace App\Tests\Domain\CredentialsManagement\Query;

use App\Domain\CredentialsManagement\Query\FindCredentialsWithEmail;
use App\Tests\Domain\CredentialsManagement\BaseTestCase;

final class FindCredentialsWithEmailTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $query = new FindCredentialsWithEmail($this->credentialsReader);

        $this->credentialsReader
            ->expects($this->once())
            ->method('findWithEmail')
            ->willReturn($this->generateCredentials());

        $query($this->generateEmail());
    }
}
