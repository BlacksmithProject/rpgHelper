<?php
declare(strict_types=1);

namespace App\Application\Model;

use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\Entity\Token;

final class AuthenticatedCredentials
{
    private $credentials;
    private $token;

    public function __construct(
        Credentials $credentials,
        Token $token
    ) {
        $this->credentials = $credentials;
        $this->token = $token;
    }

    public function expose(): array
    {
        return [
            'credentials' => [
                'id' => (string) $this->credentials->id(),
                'email' => (string) $this->credentials->email(),
                'token' => (string) $this->token->value(),
            ],
        ];
    }
}
