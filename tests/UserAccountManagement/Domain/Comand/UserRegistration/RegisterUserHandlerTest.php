<?php
declare(strict_types=1);

namespace App\Tests\UserAccountManagement\Domain\Comand\UserRegistration;

use App\UserAccountManagement\Domain\Command\UserRegistration\RegisterUserHandler;
use App\UserAccountManagement\Domain\UserAccountManagementException;
use App\Tests\UserAccountManagement\Domain\BaseTestCase;

final class RegisterUserHandlerTest extends BaseTestCase
{
    public function testItCanHandleCommand(): void
    {
        $handler = new RegisterUserHandler($this->userReader, $this->userWriter);

        $this->userReader
            ->expects($this->once())
            ->method('isEmailAlreadyUsed')
            ->willReturn(false);

        $this->userReader
            ->expects($this->once())
            ->method('isNameAlreadyUsed')
            ->willReturn(false);

        $this->userWriter
            ->expects($this->once())
            ->method('add');

        $handler($this->generateRegisterUserCommand());
    }

    public function testItCannotRegisterUserIfEmailIsAlreadyUsed(): void
    {
        $handler = new RegisterUserHandler($this->userReader, $this->userWriter);

        $this->userReader
            ->expects($this->once())
            ->method('isEmailAlreadyUsed')
            ->willReturn(true);

        $this->userReader
            ->expects($this->never())
            ->method('isNameAlreadyUsed');

        $this->userWriter
            ->expects($this->never())
            ->method('add');

        $this->expectException(UserAccountManagementException::class);
        $this->expectExceptionMessage('user.email.already_used');

        $handler($this->generateRegisterUserCommand());
    }

    public function testItCannotRegisterUserIfNameIsAlreadyUsed(): void
    {
        $handler = new RegisterUserHandler($this->userReader, $this->userWriter);

        $this->userReader
            ->expects($this->once())
            ->method('isEmailAlreadyUsed')
            ->willReturn(false);

        $this->userReader
            ->expects($this->once())
            ->method('isNameAlreadyUsed')
            ->willReturn(true);

        $this->userWriter
            ->expects($this->never())
            ->method('add');

        $this->expectException(UserAccountManagementException::class);
        $this->expectExceptionMessage('user.name.already_used');

        $handler($this->generateRegisterUserCommand());
    }
}
