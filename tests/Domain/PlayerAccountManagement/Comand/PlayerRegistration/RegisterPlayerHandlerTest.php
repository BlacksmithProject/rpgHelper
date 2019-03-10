<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement\Comand\PlayerRegistration;

use App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterPlayerHandler;
use App\Domain\PlayerAccountManagement\PlayerAccountManagementException;
use App\Tests\Domain\PlayerAccountManagement\BaseTestCase;

final class RegisterPlayerHandlerTest extends BaseTestCase
{
    public function testItCanHandleCommand(): void
    {
        $handler = new RegisterPlayerHandler($this->playerReader, $this->playerWriter);

        $this->playerReader
            ->expects($this->once())
            ->method('isEmailAlreadyUsed')
            ->willReturn(false);

        $this->playerReader
            ->expects($this->once())
            ->method('isNameAlreadyUsed')
            ->willReturn(false);

        $this->playerWriter
            ->expects($this->once())
            ->method('add');

        $handler($this->generateRegisterPlayerCommand());
    }

    public function testItCannotRegisterPlayerIfEmailIsAlreadyUsed(): void
    {
        $handler = new RegisterPlayerHandler($this->playerReader, $this->playerWriter);

        $this->playerReader
            ->expects($this->once())
            ->method('isEmailAlreadyUsed')
            ->willReturn(true);

        $this->playerReader
            ->expects($this->never())
            ->method('isNameAlreadyUsed');

        $this->playerWriter
            ->expects($this->never())
            ->method('add');

        $this->expectException(PlayerAccountManagementException::class);
        $this->expectExceptionMessage('player.email.already_used');

        $handler($this->generateRegisterPlayerCommand());
    }

    public function testItCannotRegisterPlayerIfNameIsAlreadyUsed(): void
    {
        $handler = new RegisterPlayerHandler($this->playerReader, $this->playerWriter);

        $this->playerReader
            ->expects($this->once())
            ->method('isEmailAlreadyUsed')
            ->willReturn(false);

        $this->playerReader
            ->expects($this->once())
            ->method('isNameAlreadyUsed')
            ->willReturn(true);

        $this->playerWriter
            ->expects($this->never())
            ->method('add');

        $this->expectException(PlayerAccountManagementException::class);
        $this->expectExceptionMessage('player.name.already_used');

        $handler($this->generateRegisterPlayerCommand());
    }
}
