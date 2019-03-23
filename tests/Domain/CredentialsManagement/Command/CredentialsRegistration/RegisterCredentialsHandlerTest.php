<?php
declare(strict_types=1);

namespace App\Tests\Domain\CredentialsManagement\Command\CredentialsRegistration;

use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterCredentialsHandler;
use App\Domain\CredentialsManagement\CredentialsManagementException;
use App\Tests\Domain\CredentialsManagement\BaseTestCase;

final class RegisterCredentialsHandlerTest extends BaseTestCase
{
    public function testItCanHandleCommand(): void
    {
        $handler = new RegisterCredentialsHandler($this->credentialsReader, $this->credentialsWriter);

        $this->credentialsReader
            ->expects($this->once())
            ->method('isEmailAlreadyUsed')
            ->willReturn(false);

        $this->credentialsWriter
            ->expects($this->once())
            ->method('add');

        $handler($this->generateRegisterCredentialsCommand());
    }

    public function testItCannotRegisterCredentialsIfEmailIsAlreadyUsed(): void
    {
        $handler = new RegisterCredentialsHandler($this->credentialsReader, $this->credentialsWriter);

        $this->credentialsReader
            ->expects($this->once())
            ->method('isEmailAlreadyUsed')
            ->willReturn(true);

        $this->credentialsWriter
            ->expects($this->never())
            ->method('add');

        $this->expectException(CredentialsManagementException::class);
        $this->expectExceptionMessage('credentials.email.already_used');

        $handler($this->generateRegisterCredentialsCommand());
    }
}
