<?php
declare(strict_types=1);

namespace App\Application\UserAccountManagement\API;

use App\Application\UserAccountManagement\Model\AuthenticatedUser;
use App\Application\Shared\Exception\ApplicationException;
use App\Application\UserAccountManagement\Service\SignInUser;
use App\Domain\UserAccountManagement\ErrorMessage;
use Assert\Assert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SignInController
{
    private const FIELD_EMAIL = 'email';
    private const FIELD_PASSWORD = 'password';

    private $signInUser;

    public function __construct(SignInUser $signInUser)
    {
        $this->signInUser = $signInUser;
    }

    /**
     * @throws \App\Application\Shared\Exception\ApplicationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $decodedAuthorization = $this->getDecodedAuthorization($request);

        $this->validateRequest($decodedAuthorization[0], $decodedAuthorization[1]);

        /** @var AuthenticatedUser $user */
        $user = ($this->signInUser)(
            $decodedAuthorization[0],
            $decodedAuthorization[1]
        );

        return new JsonResponse($user->expose(), Response::HTTP_OK);
    }

    /**
     * @throws ApplicationException
     */
    private function getDecodedAuthorization(Request $request)
    {
        Assert::lazy()
            ->that($request->headers->get('Authorization'), 'authHeader')
            ->notNull('authorization.basic.missing_header')
            ->verifyNow();

        if (!is_string($request->headers->get('Authorization'))) {
            throw new ApplicationException('missing.header');
        }

        $encodedAuthorization = explode(' ', $request->headers->get('Authorization'));

        return explode(':', (string) base64_decode($encodedAuthorization[1]));
    }

    private function validateRequest(?string $email, ?string $password): void
    {
        Assert::lazy()
            ->that($email, static::FIELD_EMAIL)
            ->notNull(ErrorMessage::EMAIL_CANNOT_BE_NULL())
            ->notBlank(ErrorMessage::EMAIL_CANNOT_BE_BLANK())
            ->email(ErrorMessage::EMAIL_MUST_BE_VALID())

            ->that($password, static::FIELD_PASSWORD)
            ->notNull(ErrorMessage::PASSWORD_CANNOT_BE_NULL())
            ->notBlank(ErrorMessage::PASSWORD_CANNOT_BE_BLANK())

            ->verifyNow();
    }
}
