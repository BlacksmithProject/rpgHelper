<?php
declare(strict_types=1);

namespace App\Application\Model;

use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\Entity\Token;
use App\Domain\GameManagement\Entity\Player;

final class AuthenticatedPlayer
{
    private $credentials;
    private $token;
    private $player;

    public function __construct(
        Credentials $credentials,
        Token $token,
        Player $player
    ) {
        $this->credentials = $credentials;
        $this->token = $token;
        $this->player = $player;
    }

    public function expose(): array
    {
        return [
            'player' => [
                'id' => (string) $this->credentials->id(),
                'email' => (string) $this->credentials->email(),
                'token' => (string) $this->token->value(),
                'name' => (string) $this->player->name(),
            ],
        ];
    }
}
