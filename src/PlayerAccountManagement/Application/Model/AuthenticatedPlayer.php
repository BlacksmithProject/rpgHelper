<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Application\Model;

use App\PlayerAccountManagement\Domain\Entity\Player;
use App\PlayerAccountManagement\Domain\Entity\Token;

final class AuthenticatedPlayer
{
    private $player;
    private $token;

    public function __construct(
        Player $player,
        Token $token
    ) {
        $this->player = $player;
        $this->token = $token;
    }

    public function expose(): array
    {
        return [
            'player' => [
                'id' => (string) $this->player->id(),
                'email' => (string) $this->player->email(),
                'name' => (string) $this->player->name(),
                'token' => (string) $this->token->value(),
            ],
        ];
    }
}
