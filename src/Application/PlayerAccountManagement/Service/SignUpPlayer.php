<?php
declare(strict_types=1);

namespace App\Application\PlayerAccountManagement\Service;

use App\Application\PlayerAccountManagement\Model\AuthenticatedPlayer;
use App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterPlayer;
use App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterAuthenticationToken;
use App\Domain\PlayerAccountManagement\PlayerCommandBus;
use App\Domain\PlayerAccountManagement\Query\FindPlayerWithId;
use App\Application\Shared\Identity;
use App\Domain\PlayerAccountManagement\Query\FindTokenWithPlayerIdAndType;
use App\Domain\PlayerAccountManagement\ValueObject\TokenType;
use Doctrine\DBAL\Connection;

final class SignUpPlayer
{
    private $playerCommandBus;
    private $findPlayerWithId;
    private $findTokenWithPlayerIdAndType;
    private $connection;

    public function __construct(
        PlayerCommandBus $playerCommandBus,
        FindPlayerWithId $findPlayerWithId,
        FindTokenWithPlayerIdAndType $findTokenWithPlayerIdAndType,
        Connection $connection
    ) {
        $this->playerCommandBus = $playerCommandBus;
        $this->findPlayerWithId = $findPlayerWithId;
        $this->findTokenWithPlayerIdAndType = $findTokenWithPlayerIdAndType;
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
            $playerId = Identity::generate();
            $tokenId = Identity::generate();

            ($this->playerCommandBus)(new RegisterPlayer($playerId, $email, $password, $name));
            ($this->playerCommandBus)(new RegisterAuthenticationToken($tokenId, $playerId));

            $player = ($this->findPlayerWithId)($playerId);
            $token = ($this->findTokenWithPlayerIdAndType)($playerId, TokenType::AUTHENTICATION());

            $authenticatedPlayer = new AuthenticatedPlayer($player, $token);

            $this->connection->commit();

            return $authenticatedPlayer;
        } catch (\Exception $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }
}
