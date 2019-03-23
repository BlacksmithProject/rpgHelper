<?php
declare(strict_types=1);

namespace App\Domain\UserAccountManagement\Command\UserRegistration;

use App\Domain\UserAccountManagement\ValueObject\UserId;
use App\Domain\UserAccountManagement\ValueObject\TokenId;

final class RegisterAuthenticationToken
{
    private $tokenId;
    private $userId;

    public function __construct(TokenId $tokenId, UserId $userId)
    {
        $this->tokenId = $tokenId;
        $this->userId = $userId;
    }

    public function tokenId(): TokenId
    {
        return $this->tokenId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }
}
