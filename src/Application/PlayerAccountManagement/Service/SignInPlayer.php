<?php
declare(strict_types=1);

namespace App\Application\PlayerAccountManagement\Service;

use App\Application\Shared\Exception\ApplicationException;
use App\Application\PlayerAccountManagement\Model\AuthenticatedPlayer;
use App\Domain\PlayerAccountManagement\Entity\Player;
use App\Domain\PlayerAccountManagement\Entity\Token;
use App\Domain\PlayerAccountManagement\Query\FindPlayerWithEmail;
use App\Domain\PlayerAccountManagement\Query\FindTokenWithPlayerIdAndType;
use App\Domain\PlayerAccountManagement\ValueObject\Email;
use App\Domain\PlayerAccountManagement\ValueObject\PlainPassword;
use App\Domain\PlayerAccountManagement\ValueObject\TokenType;

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
