<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Infrastructure\Doctrine\Exception;

use MyCLabs\Enum\Enum;

/**
 * @method static ErrorMessage USER_NOT_FOUND()
 * @method static ErrorMessage TOKEN_NOT_FOUND()
 */
final class ErrorMessage extends Enum
{
    private const USER_NOT_FOUND = 'user.not_found';
    private const TOKEN_NOT_FOUND = 'token.not_found';
}
