<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Player\Exception;

use MyCLabs\Enum\Enum;

/**
 * @method static ErrorMessage PLAYER_NOT_FOUND()
 * @method static ErrorMessage TOKEN_NOT_FOUND()
 */
final class ErrorMessage extends Enum
{
    private const PLAYER_NOT_FOUND = 'player.not_found';
    private const TOKEN_NOT_FOUND = 'token.not_found';
}
