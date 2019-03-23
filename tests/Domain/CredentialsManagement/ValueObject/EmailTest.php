<?php
declare(strict_types=1);

namespace App\Tests\Domain\CredentialsManagement\ValueObject;

use App\Domain\CredentialsManagement\ValueObject\Email;
use App\Tests\Domain\CredentialsManagement\BaseTestCase;
use Assert\InvalidArgumentException;

final class EmailTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $email = new Email('john.snow@winterfell.north');

        $this->assertSame('john.snow@winterfell.north', (string) $email);
    }

    public function testItCannotHaveANullParameter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('credentials.email.cannot_be_null');

        new Email(null);
    }

    public function testItCannotHaveABlankParameter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('credentials.email.cannot_be_blank');

        new Email('');
    }

    public function testItCannotHaveAnInvalidEmailAsParameter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('credentials.email.must_be_valid');

        new Email('not-an-email');
    }
}
