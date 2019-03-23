<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement\ValueObject;

use MyCLabs\Enum\Enum;

/**
 * @method static TokenType AUTHENTICATION()
 */
final class TokenType extends Enum
{
    private const AUTHENTICATION = 'authentication';
}
