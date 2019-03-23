<?php
declare(strict_types=1);

namespace App\Tests\Domain\CredentialsManagement\Command\CredentialsRegistration;

use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterAuthenticationToken;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;
use App\Domain\CredentialsManagement\ValueObject\TokenId;
use App\Tests\Domain\CredentialsManagement\BaseTestCase;

final class RegisterAuthenticationTokenTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $command = new RegisterAuthenticationToken($this->generateTokenId(), $this->generateCredentialsId());

        $this->assertInstanceOf(TokenId::class, $command->tokenId());
        $this->assertInstanceOf(CredentialsId::class, $command->credentialsId());
    }
}
