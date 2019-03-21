<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Application\Model;

use App\UserAccountManagement\Domain\Entity\User;
use App\UserAccountManagement\Domain\Entity\Token;

final class AuthenticatedUser
{
    private $user;
    private $token;

    public function __construct(
        User $user,
        Token $token
    ) {
        $this->user = $user;
        $this->token = $token;
    }

    public function expose(): array
    {
        return [
            'user' => [
                'id' => (string) $this->user->id(),
                'email' => (string) $this->user->email(),
                'name' => (string) $this->user->name(),
                'token' => (string) $this->token->value(),
            ],
        ];
    }
}
