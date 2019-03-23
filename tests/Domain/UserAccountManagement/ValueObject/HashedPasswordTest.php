<?php
declare(strict_types=1);

namespace App\Tests\Domain\UserAccountManagement\ValueObject;

use App\Domain\UserAccountManagement\ValueObject\HashedPassword;
use App\Tests\Domain\UserAccountManagement\BaseTestCase;

final class HashedPasswordTest extends BaseTestCase
{
    public function testItCanBeInitializedFromPlainPassword(): void
    {
        $plainPassword = $this->generatePlainPassword();

        $hashedPassword = HashedPassword::fromPlainPassword($plainPassword);

        $this->assertGreaterThanOrEqual(36, strlen((string) $hashedPassword));
        $this->assertTrue($hashedPassword->isSameThan($plainPassword));
    }

    public function testItCanBeInitializedFromHash(): void
    {
        $plainPassword = $this->generatePlainPassword();

        $hash = (string) (HashedPassword::fromPlainPassword($plainPassword));

        $hashedPassword = HashedPassword::fromHash($hash);

        $this->assertGreaterThanOrEqual(36, strlen((string) $hashedPassword));
        $this->assertTrue($hashedPassword->isSameThan($plainPassword));
    }

    public function testItCanVerifyThatWrongPasswordAreNotTheSame(): void
    {
        $hashedPassword = HashedPassword::fromPlainPassword($this->generatePlainPassword());
        $plainPassword = $this->generatePlainPassword('andNowMyWatchBegins');

        $this->assertFalse($hashedPassword->isSameThan($plainPassword));
    }
}
