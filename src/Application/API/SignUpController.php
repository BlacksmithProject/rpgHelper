<?php
declare(strict_types=1);

namespace App\Application\API;

use App\Application\Model\AuthenticatedPlayer;
use App\Domain\CredentialsManagement\ErrorMessage;
use App\Application\Service\SignUp;
use Assert\Assert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SignUpController
{
    private const FIELD_EMAIL = 'email';
    private const FIELD_PASSWORD = 'password';
    private const FIELD_NAME = 'name';

    private $signUp;

    public function __construct(SignUp $signUp)
    {
        $this->signUp = $signUp;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->validateRequest($request);

        /** @var AuthenticatedPlayer $player */
        $player = ($this->signUp)(
            $request->request->get('email'),
            $request->request->get('password'),
            $request->request->get('name')
        );

        return new JsonResponse($player->expose(), Response::HTTP_CREATED);
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
            ->notNull(\App\Domain\GameManagement\ErrorMessage::PLAYER_NAME_CANNOT_BE_NULL())
            ->notBlank(\App\Domain\GameManagement\ErrorMessage::PLAYER_NAME_CANNOT_BE_BLANK())

            ->verifyNow();
    }
}
