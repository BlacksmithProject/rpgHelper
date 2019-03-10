<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement\Comand\PlayerRegistration;

use App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterAuthenticationTokenHandler;
use App\Tests\Domain\PlayerAccountManagement\BaseTestCase;

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
