<?php
declare(strict_types=1);

namespace App\Tests\Domain\CredentialsManagement\Entity;

use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;
use App\Tests\Domain\CredentialsManagement\BaseTestCase;

final class CredentialsTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $credentials = new Credentials(
            $this->generateCredentialsId(),
            $this->generateEmail(),
            $this->generateHashedPassword()
        );

        $this->assertInstanceOf(CredentialsId::class, $credentials->id());
        $this->assertSame('john.snow@winterfell.north', (string) $credentials->email());
        $this->assertTrue($credentials->hashedPassword()->isSameThan($this->generatePlainPassword()));
    }
}
