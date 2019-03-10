<?php
declare(strict_types=1);

namespace App\Tests\Domain\PlayerAccountManagement\ValueObject;

use App\Domain\PlayerAccountManagement\ValueObject\TokenValue;
use App\Tests\Domain\PlayerAccountManagement\BaseTestCase;

final class TokenValueTest extends BaseTestCase
{
    public function testItCanBeInitialized(): void
    {
        $tokenValue = TokenValue::generate();

        $this->assertInstanceOf(TokenValue::class, $tokenValue);
        $this->assertGreaterThanOrEqual(36, strlen((string) $tokenValue));
    }
}
