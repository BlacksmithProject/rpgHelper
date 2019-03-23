<?php
declare(strict_types=1);

namespace App\Tests\Domain\CredentialsManagement\Command\CredentialsRegistration;

use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterCredentials;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;
use App\Tests\Domain\CredentialsManagement\BaseTestCase;

final class RegisterCredentialsTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $command = new RegisterCredentials(
            $this->generateCredentialsId(),
            'john.snow@winterfell.north',
            'winterIsComing'
        );

        $this->assertInstanceOf(CredentialsId::class, $command->credentialsId());
        $this->assertSame('john.snow@winterfell.north', (string) $command->email());
        $this->assertSame('winterIsComing', (string) $command->plainPassword());
    }
}
