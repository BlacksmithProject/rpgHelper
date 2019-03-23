<?php
declare(strict_types=1);

namespace App\Tests\Domain\UserAccountManagement\Comand\UserRegistration;

use App\Domain\UserAccountManagement\Command\UserRegistration\RegisterUser;
use App\Domain\UserAccountManagement\ValueObject\UserId;
use App\Tests\Domain\UserAccountManagement\BaseTestCase;

final class RegisterUserTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $command = new RegisterUser(
            $this->generateUserId(),
            'john.snow@winterfell.north',
            'winterIsComing',
            'White Wolf'
        );

        $this->assertInstanceOf(UserId::class, $command->userId());
        $this->assertSame('john.snow@winterfell.north', (string) $command->email());
        $this->assertSame('winterIsComing', (string) $command->plainPassword());
        $this->assertSame('White Wolf', (string) $command->userName());
    }
}
