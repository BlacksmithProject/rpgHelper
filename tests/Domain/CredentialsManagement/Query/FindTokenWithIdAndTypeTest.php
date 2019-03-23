<?php
declare(strict_types=1);

namespace App\Tests\Domain\CredentialsManagement\Query;

use App\Domain\CredentialsManagement\Query\FindTokenWithCredentialsIdAndType;
use App\Domain\CredentialsManagement\ValueObject\TokenType;
use App\Tests\Domain\CredentialsManagement\BaseTestCase;

final class FindTokenWithIdAndTypeTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $query = new FindTokenWithCredentialsIdAndType($this->tokenReader);

        $this->tokenReader
            ->expects($this->once())
            ->method('findWithCredentialsIdAndType')
            ->willReturn($this->generateToken());

        $query($this->generateCredentialsId(), TokenType::AUTHENTICATION());
    }
}
