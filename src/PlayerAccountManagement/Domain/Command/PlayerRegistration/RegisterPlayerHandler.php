<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Domain\Command\PlayerRegistration;

use App\PlayerAccountManagement\Domain\Entity\Player;
use App\PlayerAccountManagement\Domain\ErrorMessage;
use App\PlayerAccountManagement\Domain\PlayerAccountManagementException;
use App\PlayerAccountManagement\Domain\Port\PlayerReader;
use App\PlayerAccountManagement\Domain\Port\PlayerWriter;
use App\PlayerAccountManagement\Domain\ValueObject\HashedPassword;

final class RegisterPlayerHandler
{
    private $playerReader;
    private $playerWriter;

    public function __construct(PlayerReader $playerReader, PlayerWriter $playerWriter)
    {
        $this->playerReader = $playerReader;
        $this->playerWriter = $playerWriter;
    }

    /**
     * @throws PlayerAccountManagementException
     * @throws \App\Shared\Infrastructure\Exception\InternalException
     */
    public function __invoke(RegisterPlayer $registerPlayer)
    {
        if ($this->playerReader->isEmailAlreadyUsed($registerPlayer->email())) {
            throw new PlayerAccountManagementException((string) ErrorMessage::EMAIL_ALREADY_USED());
        }

        if ($this->playerReader->isNameAlreadyUsed($registerPlayer->playerName())) {
            throw new PlayerAccountManagementException((string) ErrorMessage::NAME_ALREADY_USED());
        }

        $player = new Player(
            $registerPlayer->playerId(),
            $registerPlayer->email(),
            HashedPassword::fromPlainPassword($registerPlayer->plainPassword()),
            $registerPlayer->playerName()
        );

        $this->playerWriter->add($player);
    }
}
