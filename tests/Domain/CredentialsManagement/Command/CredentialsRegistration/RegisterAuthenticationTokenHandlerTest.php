<?php
declare(strict_types=1);

namespace App\Tests\Domain\CredentialsManagement\Command\CredentialsRegistration;

use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterAuthenticationTokenHandler;
use App\Tests\Domain\CredentialsManagement\BaseTestCase;

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
