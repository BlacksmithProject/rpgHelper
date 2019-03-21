<?php
declare(strict_types=1);

namespace App\Tests\UserAccountManagement\Domain\Comand\UserRegistration;

use App\UserAccountManagement\Domain\Command\UserRegistration\RegisterAuthenticationTokenHandler;
use App\Tests\UserAccountManagement\Domain\BaseTestCase;

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
