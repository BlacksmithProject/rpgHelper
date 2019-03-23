<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement;

use MyCLabs\Enum\Enum;

/**
 * @method static ErrorMessage EMAIL_CANNOT_BE_NULL()
 * @method static ErrorMessage EMAIL_CANNOT_BE_BLANK()
 * @method static ErrorMessage EMAIL_MUST_BE_VALID()
 * @method static ErrorMessage EMAIL_ALREADY_USED()
 *
 * @method static ErrorMessage PASSWORD_CANNOT_BE_NULL()
 * @method static ErrorMessage PASSWORD_CANNOT_BE_BLANK()
 *
 * @method static ErrorMessage NAME_CANNOT_BE_NULL()
 * @method static ErrorMessage NAME_CANNOT_BE_BLANK()
 * @method static ErrorMessage NAME_ALREADY_USED()
 *
 * @method static ErrorMessage TOKEN_VALUE_CANNOT_BE_NULL()
 * @method static ErrorMessage TOKEN_VALUE_CANNOT_BE_BLANK()
 */
final class ErrorMessage extends Enum
{
    private const EMAIL_CANNOT_BE_NULL = 'user.email.cannot_be_null';
    private const EMAIL_CANNOT_BE_BLANK = 'user.email.cannot_be_blank';
    private const EMAIL_MUST_BE_VALID = 'user.email.must_be_valid';
    private const EMAIL_ALREADY_USED = 'user.email.already_used';

    private const PASSWORD_CANNOT_BE_NULL = 'user.password.cannot_be_null';
    private const PASSWORD_CANNOT_BE_BLANK = 'user.password.cannot_be_blank';

    private const NAME_CANNOT_BE_NULL = 'user.name.cannot_be_null';
    private const NAME_CANNOT_BE_BLANK = 'user.name.cannot_be_blank';
    private const NAME_ALREADY_USED = 'user.name.already_used';

    private const TOKEN_VALUE_CANNOT_BE_NULL = 'user.token_value.cannot_be_null';
    private const TOKEN_VALUE_CANNOT_BE_BLANK = 'user.token_value.cannot_be_blank';
}
