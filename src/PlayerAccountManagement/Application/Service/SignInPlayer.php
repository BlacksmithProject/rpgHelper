<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Application\Service;

use App\Shared\Application\Exception\ApplicationException;
use App\PlayerAccountManagement\Application\Model\AuthenticatedPlayer;
use App\PlayerAccountManagement\Domain\Entity\Player;
use App\PlayerAccountManagement\Domain\Entity\Token;
use App\PlayerAccountManagement\Domain\Query\FindPlayerWithEmail;
use App\PlayerAccountManagement\Domain\Query\FindTokenWithPlayerIdAndType;
use App\PlayerAccountManagement\Domain\ValueObject\Email;
use App\PlayerAccountManagement\Domain\ValueObject\PlainPassword;
use App\PlayerAccountManagement\Domain\ValueObject\TokenType;

final class SignInPlayer
{
    private $findPlayerWithEmail;
    private $findTokenWithPlayerIdAndType;

    public function __construct(
        FindPlayerWithEmail $findPlayerWithEmail,
        FindTokenWithPlayerIdAndType $findTokenWithPlayerIdAndType
    ) {
        $this->findPlayerWithEmail = $findPlayerWithEmail;
        $this->findTokenWithPlayerIdAndType = $findTokenWithPlayerIdAndType;
    }

    /**
     * @throws ApplicationException
     */
    public function __invoke(?string $email, ?string $password): AuthenticatedPlayer
    {
        $email = new Email($email);
        $plainPassword = new PlainPassword($password);

        /** @var Player $player */
        $player = ($this->findPlayerWithEmail)($email);

        if (!$player->hashedPassword()->isSameThan($plainPassword)) {
            throw new ApplicationException();
        }

        /** @var Token $token */
        $token = ($this->findTokenWithPlayerIdAndType)($player->id(), TokenType::AUTHENTICATION());

        return new AuthenticatedPlayer($player, $token);
    }
}
