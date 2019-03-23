<?php
declare(strict_types=1);

namespace App\Application\CredentialsManagement\Service;

use App\Application\CredentialsManagement\Model\AuthenticatedCredentials;
use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterCredentials;
use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterAuthenticationToken;
use App\Domain\CredentialsManagement\CredentialsCommandBus;
use App\Domain\CredentialsManagement\Query\FindCredentialsWithId;
use App\Application\Shared\Identity;
use App\Domain\CredentialsManagement\Query\FindTokenWithCredentialsIdAndType;
use App\Domain\CredentialsManagement\ValueObject\TokenType;
use Doctrine\DBAL\Connection;

final class SignUpCredentials
{
    private $credentialsCommandBus;
    private $findCredentialsWithId;
    private $findTokenWithCredentialsIdAndType;
    private $connection;

    public function __construct(
        CredentialsCommandBus $credentialsCommandBus,
        FindCredentialsWithId $findCredentialsWithId,
        FindTokenWithCredentialsIdAndType $findTokenWithCredentialsIdAndType,
        Connection $connection
    ) {
        $this->credentialsCommandBus = $credentialsCommandBus;
        $this->findCredentialsWithId = $findCredentialsWithId;
        $this->findTokenWithCredentialsIdAndType = $findTokenWithCredentialsIdAndType;
        $this->connection = $connection;
    }

    /**
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Exception
     */
    public function __invoke(?string $email, ?string $password): AuthenticatedCredentials
    {
        $this->connection->beginTransaction();

        try {
            $credentialsId = Identity::generate();
            $tokenId = Identity::generate();

            ($this->credentialsCommandBus)(new RegisterCredentials($credentialsId, $email, $password));
            ($this->credentialsCommandBus)(new RegisterAuthenticationToken($tokenId, $credentialsId));

            $credentials = ($this->findCredentialsWithId)($credentialsId);
            $token = ($this->findTokenWithCredentialsIdAndType)($credentialsId, TokenType::AUTHENTICATION());

            $authenticatedCredentials = new AuthenticatedCredentials($credentials, $token);

            $this->connection->commit();

            return $authenticatedCredentials;
        } catch (\Exception $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }
}
