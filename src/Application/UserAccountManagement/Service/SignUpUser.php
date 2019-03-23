<?php
declare(strict_types=1);

namespace App\Application\UserAccountManagement\Service;

use App\Application\UserAccountManagement\Model\AuthenticatedUser;
use App\Domain\UserAccountManagement\Command\UserRegistration\RegisterUser;
use App\Domain\UserAccountManagement\Command\UserRegistration\RegisterAuthenticationToken;
use App\Domain\UserAccountManagement\UserCommandBus;
use App\Domain\UserAccountManagement\Query\FindUserWithId;
use App\Application\Shared\Identity;
use App\Domain\UserAccountManagement\Query\FindTokenWithUserIdAndType;
use App\Domain\UserAccountManagement\ValueObject\TokenType;
use Doctrine\DBAL\Connection;

final class SignUpUser
{
    private $userCommandBus;
    private $findUserWithId;
    private $findTokenWithUserIdAndType;
    private $connection;

    public function __construct(
        UserCommandBus $userCommandBus,
        FindUserWithId $findUserWithId,
        FindTokenWithUserIdAndType $findTokenWithUserIdAndType,
        Connection $connection
    ) {
        $this->userCommandBus = $userCommandBus;
        $this->findUserWithId = $findUserWithId;
        $this->findTokenWithUserIdAndType = $findTokenWithUserIdAndType;
        $this->connection = $connection;
    }

    /**
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Exception
     */
    public function __invoke(?string $email, ?string $password, ?string $name): AuthenticatedUser
    {
        $this->connection->beginTransaction();

        try {
            $userId = Identity::generate();
            $tokenId = Identity::generate();

            ($this->userCommandBus)(new RegisterUser($userId, $email, $password, $name));
            ($this->userCommandBus)(new RegisterAuthenticationToken($tokenId, $userId));

            $user = ($this->findUserWithId)($userId);
            $token = ($this->findTokenWithUserIdAndType)($userId, TokenType::AUTHENTICATION());

            $authenticatedUser = new AuthenticatedUser($user, $token);

            $this->connection->commit();

            return $authenticatedUser;
        } catch (\Exception $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }
}
