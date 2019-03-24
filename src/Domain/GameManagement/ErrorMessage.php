<?php
declare(strict_types=1);

namespace App\Domain\GameManagement;

use MyCLabs\Enum\Enum;

/**
 * @method static ErrorMessage PLAYER_NAME_CANNOT_BE_NULL()
 * @method static ErrorMessage PLAYER_NAME_CANNOT_BE_BLANK()
 * @method static ErrorMessage PLAYER_NAME_ALREADY_USED()
 */
final class ErrorMessage extends Enum
{
    private const PLAYER_NAME_CANNOT_BE_NULL = 'player.name.cannot_be_null';
    private const PLAYER_NAME_CANNOT_BE_BLANK = 'player.name.cannot_be_blank';
    private const PLAYER_NAME_ALREADY_USED = 'player.name.already_used';
}
