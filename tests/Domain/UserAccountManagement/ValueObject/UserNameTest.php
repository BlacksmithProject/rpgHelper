<?php
declare(strict_types=1);

namespace App\Tests\Domain\UserAccountManagement\ValueObject;

use App\Domain\UserAccountManagement\ValueObject\UserName;
use App\Tests\Domain\UserAccountManagement\BaseTestCase;
use Assert\InvalidArgumentException;

final class UserNameTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $plainPassword = new UserName('White Wolf');

        $this->assertSame('White Wolf', (string) $plainPassword);
    }

    public function testItCannotHaveANullParameter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('user.name.cannot_be_null');

        new UserName(null);
    }

    public function testItCannotHaveABlankParameter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('user.name.cannot_be_blank');

        new UserName('');
    }
}
