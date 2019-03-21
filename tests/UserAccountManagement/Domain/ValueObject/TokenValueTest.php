<?php
declare(strict_types=1);

namespace App\Tests\UserAccountManagement\Domain\ValueObject;

use App\UserAccountManagement\Domain\ValueObject\TokenValue;
use App\Tests\UserAccountManagement\Domain\BaseTestCase;

final class TokenValueTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $tokenValue = TokenValue::generate();

        $this->assertInstanceOf(TokenValue::class, $tokenValue);
        $this->assertGreaterThanOrEqual(36, strlen((string) $tokenValue));
    }
}
