<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Application\API;

use App\UserAccountManagement\Application\Model\AuthenticatedUser;
use App\UserAccountManagement\Domain\ErrorMessage;
use App\UserAccountManagement\Application\Service\SignUpUser;
use Assert\Assert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SignUpController
{
    private const FIELD_EMAIL = 'email';
    private const FIELD_PASSWORD = 'password';
    private const FIELD_NAME = 'name';

    private $signUpUser;

    public function __construct(SignUpUser $signUpUser)
    {
        $this->signUpUser = $signUpUser;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->validateRequest($request);

        /** @var AuthenticatedUser $authenticatedUser */
        $authenticatedUser = ($this->signUpUser)(
            $request->request->get('email'),
            $request->request->get('password'),
            $request->request->get('name')
        );

        return new JsonResponse($authenticatedUser->expose(), Response::HTTP_CREATED);
    }

    private function validateRequest(Request $request): void
    {
        Assert::lazy()
            ->that($request->request->get(static::FIELD_EMAIL), static::FIELD_EMAIL)
            ->notNull(ErrorMessage::EMAIL_CANNOT_BE_NULL())
            ->notBlank(ErrorMessage::EMAIL_CANNOT_BE_BLANK())
            ->email(ErrorMessage::EMAIL_MUST_BE_VALID())

            ->that($request->request->get(static::FIELD_PASSWORD), static::FIELD_PASSWORD)
            ->notNull(ErrorMessage::PASSWORD_CANNOT_BE_NULL())
            ->notBlank(ErrorMessage::PASSWORD_CANNOT_BE_BLANK())

            ->that($request->request->get(static::FIELD_NAME), static::FIELD_NAME)
            ->notNull(ErrorMessage::NAME_CANNOT_BE_NULL())
            ->notBlank(ErrorMessage::NAME_CANNOT_BE_BLANK())

            ->verifyNow();
    }
}
