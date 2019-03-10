<?php
declare(strict_types=1);

namespace App\Application\PlayerAccountManagement\Model;

use App\Domain\PlayerAccountManagement\Entity\Player;
use App\Domain\PlayerAccountManagement\Entity\Token;

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
