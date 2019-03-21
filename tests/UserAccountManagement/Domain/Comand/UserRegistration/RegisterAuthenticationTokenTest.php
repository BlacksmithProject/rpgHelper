<?php
declare(strict_types=1);

namespace App\Tests\UserAccountManagement\Domain\Comand\UserRegistration;

use App\UserAccountManagement\Domain\Command\UserRegistration\RegisterAuthenticationToken;
use App\UserAccountManagement\Domain\ValueObject\UserId;
use App\UserAccountManagement\Domain\ValueObject\TokenId;
use App\Tests\UserAccountManagement\Domain\BaseTestCase;

final class RegisterAuthenticationTokenTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $command = new RegisterAuthenticationToken($this->generateTokenId(), $this->generateUserId());

        $this->assertInstanceOf(TokenId::class, $command->tokenId());
        $this->assertInstanceOf(UserId::class, $command->userId());
    }
}
