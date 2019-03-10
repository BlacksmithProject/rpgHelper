<?php
declare(strict_types=1);

namespace App\Domain\PlayerAccountManagement\Command\PlayerRegistration;

use App\Domain\PlayerAccountManagement\Entity\Player;
use App\Domain\PlayerAccountManagement\ErrorMessage;
use App\Domain\PlayerAccountManagement\PlayerAccountManagementException;
use App\Domain\PlayerAccountManagement\Port\PlayerReader;
use App\Domain\PlayerAccountManagement\Port\PlayerWriter;
use App\Domain\PlayerAccountManagement\ValueObject\HashedPassword;

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
     * @throws \App\Infrastructure\Exception\InternalException
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
