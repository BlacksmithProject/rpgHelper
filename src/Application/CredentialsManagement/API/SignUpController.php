<?php
declare(strict_types=1);

namespace App\Application\CredentialsManagement\API;

use App\Application\CredentialsManagement\Model\AuthenticatedCredentials;
use App\Domain\CredentialsManagement\ErrorMessage;
use App\Application\CredentialsManagement\Service\SignUpCredentials;
use Assert\Assert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SignUpController
{
    private const FIELD_EMAIL = 'email';
    private const FIELD_PASSWORD = 'password';

    private $signUpCredentials;

    public function __construct(SignUpCredentials $signUpCredentials)
    {
        $this->signUpCredentials = $signUpCredentials;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->validateRequest($request);

        /** @var AuthenticatedCredentials $authenticatedCredentials */
        $authenticatedCredentials = ($this->signUpCredentials)(
            $request->request->get('email'),
            $request->request->get('password')
        );

        return new JsonResponse($authenticatedCredentials->expose(), Response::HTTP_CREATED);
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

            ->verifyNow();
    }
}
