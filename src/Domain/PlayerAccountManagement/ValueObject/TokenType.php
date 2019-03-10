<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\ValueObject;

use MyCLabs\Enum\Enum;

/**
 * @method static TokenType AUTHENTICATION()
 */
final class TokenType extends Enum
{
    private const AUTHENTICATION = 'authentication';
}
