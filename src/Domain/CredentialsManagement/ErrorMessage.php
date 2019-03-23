<?php
declare(strict_types=1);

namespace App\Domain\CredentialsManagement;

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
    private const EMAIL_CANNOT_BE_NULL = 'credentials.email.cannot_be_null';
    private const EMAIL_CANNOT_BE_BLANK = 'credentials.email.cannot_be_blank';
    private const EMAIL_MUST_BE_VALID = 'credentials.email.must_be_valid';
    private const EMAIL_ALREADY_USED = 'credentials.email.already_used';

    private const PASSWORD_CANNOT_BE_NULL = 'credentials.password.cannot_be_null';
    private const PASSWORD_CANNOT_BE_BLANK = 'credentials.password.cannot_be_blank';

    private const NAME_CANNOT_BE_NULL = 'credentials.name.cannot_be_null';
    private const NAME_CANNOT_BE_BLANK = 'credentials.name.cannot_be_blank';
    private const NAME_ALREADY_USED = 'credentials.name.already_used';

    private const TOKEN_VALUE_CANNOT_BE_NULL = 'credentials.token_value.cannot_be_null';
    private const TOKEN_VALUE_CANNOT_BE_BLANK = 'credentials.token_value.cannot_be_blank';
}
