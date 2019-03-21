<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Domain\Command\UserRegistration;

use App\UserAccountManagement\Domain\ValueObject\UserId;
use App\UserAccountManagement\Domain\ValueObject\TokenId;

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
