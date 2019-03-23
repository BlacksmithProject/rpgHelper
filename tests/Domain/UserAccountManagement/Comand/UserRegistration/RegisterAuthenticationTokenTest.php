<?php
declare(strict_types=1);

namespace App\Tests\Domain\UserAccountManagement\Comand\UserRegistration;

use App\Domain\UserAccountManagement\Command\UserRegistration\RegisterAuthenticationToken;
use App\Domain\UserAccountManagement\ValueObject\UserId;
use App\Domain\UserAccountManagement\ValueObject\TokenId;
use App\Tests\Domain\UserAccountManagement\BaseTestCase;

final class RegisterAuthenticationTokenTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $command = new RegisterAuthenticationToken($this->generateTokenId(), $this->generateUserId());

        $this->assertInstanceOf(TokenId::class, $command->tokenId());
        $this->assertInstanceOf(UserId::class, $command->userId());
    }
}
