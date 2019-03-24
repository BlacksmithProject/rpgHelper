<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Model\AuthenticatedPlayer;
use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterCredentials;
use App\Domain\CredentialsManagement\Command\CredentialsRegistration\RegisterAuthenticationToken;
use App\Domain\CredentialsManagement\CredentialsCommandBus;
use App\Domain\CredentialsManagement\Query\FindCredentialsWithId;
use App\Application\Shared\Identity;
use App\Domain\CredentialsManagement\Query\FindTokenWithCredentialsIdAndType;
use App\Domain\CredentialsManagement\ValueObject\TokenType;
use App\Domain\GameManagement\Command\PlayerRegistration\RegisterPlayer;
use App\Domain\GameManagement\GameCommandBus;
use App\Domain\GameManagement\Query\FindPlayerWithId;
use Doctrine\DBAL\Connection;

final class SignUp
{
    private $credentialsCommandBus;
    private $gameCommandBus;
    private $findCredentialsWithId;
    private $findTokenWithCredentialsIdAndType;
    private $findPlayerWithId;
    private $connection;

    public function __construct(
        CredentialsCommandBus $credentialsCommandBus,
        GameCommandBus $gameCommandBus,
        FindCredentialsWithId $findCredentialsWithId,
        FindTokenWithCredentialsIdAndType $findTokenWithCredentialsIdAndType,
        FindPlayerWithId $findPlayerWithId,
        Connection $connection
    ) {
        $this->credentialsCommandBus = $credentialsCommandBus;
        $this->gameCommandBus = $gameCommandBus;
        $this->findCredentialsWithId = $findCredentialsWithId;
        $this->findTokenWithCredentialsIdAndType = $findTokenWithCredentialsIdAndType;
        $this->findPlayerWithId = $findPlayerWithId;
        $this->connection = $connection;
    }

    /**
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Exception
     */
    public function __invoke(?string $email, ?string $password, ?string $name): AuthenticatedPlayer
    {
        $this->connection->beginTransaction();

        try {
            $credentialsId = Identity::generate();
            $tokenId = Identity::generate();

            ($this->credentialsCommandBus)(new RegisterCredentials($credentialsId, $email, $password));
            ($this->credentialsCommandBus)(new RegisterAuthenticationToken($tokenId, $credentialsId));
            ($this->gameCommandBus)(new RegisterPlayer($credentialsId, $name));

            $credentials = ($this->findCredentialsWithId)($credentialsId);
            $token = ($this->findTokenWithCredentialsIdAndType)($credentialsId, TokenType::AUTHENTICATION());
            $player = ($this->findPlayerWithId)($credentialsId);

            $authenticatedCredentials = new AuthenticatedPlayer($credentials, $token, $player);

            $this->connection->commit();

            return $authenticatedCredentials;
        } catch (\Exception $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }
}
