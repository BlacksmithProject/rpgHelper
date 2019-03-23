<?php
declare(strict_types=1);

namespace App\Tests\Domain\UserAccountManagement\Entity;

use App\Domain\UserAccountManagement\Entity\User;
use App\Domain\UserAccountManagement\ValueObject\UserId;
use App\Tests\Domain\UserAccountManagement\BaseTestCase;

final class UserTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $user = new User(
            $this->generateUserId(),
            $this->generateEmail(),
            $this->generateHashedPassword(),
            $this->generateUserName()
        );

        $this->assertInstanceOf(UserId::class, $user->id());
        $this->assertSame('john.snow@winterfell.north', (string) $user->email());
        $this->assertTrue($user->hashedPassword()->isSameThan($this->generatePlainPassword()));
        $this->assertSame('White Wolf', (string) $user->name());
    }
}
