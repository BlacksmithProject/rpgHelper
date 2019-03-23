<?php
declare(strict_types=1);

namespace App\Tests\Domain\UserAccountManagement\Comand\UserRegistration;

use App\Domain\UserAccountManagement\Command\UserRegistration\RegisterAuthenticationTokenHandler;
use App\Tests\Domain\UserAccountManagement\BaseTestCase;

final class RegisterAuthenticationTokenHandlerTest extends BaseTestCase
{
    public function testItCanHandleCommand(): void
    {
        $handler = new RegisterAuthenticationTokenHandler($this->tokenWriter);

        $this->tokenWriter
            ->expects($this->once())
            ->method('add');

        $handler($this->generateRegisterAuthenticationTokenCommand());
    }
}
