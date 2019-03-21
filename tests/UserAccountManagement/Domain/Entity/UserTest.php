<?php
declare(strict_types=1);

namespace App\Tests\UserAccountManagement\Domain\Entity;

use App\UserAccountManagement\Domain\Entity\User;
use App\UserAccountManagement\Domain\ValueObject\UserId;
use App\Tests\UserAccountManagement\Domain\BaseTestCase;

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
