<?php
declare(strict_types=1);

namespace App\Infrastructure\UserAccountManagement\Doctrine\Adapter;

use App\Domain\UserAccountManagement\Entity\Token;
use App\Domain\UserAccountManagement\Port\TokenReader;
use App\Domain\UserAccountManagement\Port\TokenWriter;
use App\Domain\UserAccountManagement\ValueObject\UserId;
use App\Domain\UserAccountManagement\ValueObject\TokenId;
use App\Domain\UserAccountManagement\ValueObject\TokenType;
use App\Infrastructure\Shared\Doctrine\Exception\NotFoundException;
use App\Infrastructure\UserAccountManagement\Doctrine\Exception\ErrorMessage;
use App\Infrastructure\UserAccountManagement\Doctrine\TokenDataMapper;
use App\Infrastructure\Shared\Exception\InternalException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;

final class TokenRepository extends ServiceEntityRepository implements TokenReader, TokenWriter
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TokenDataMapper::class);
    }

    /**
     * @throws InternalException
     */
    public function add(Token $token): void
    {
        $tokenDataMapper = new TokenDataMapper($token);

        try {
            $this->_em->persist($tokenDataMapper);
            $this->_em->flush($tokenDataMapper);
        } catch (ORMException $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws InternalException
     * @throws NotFoundException
     */
    public function get(TokenId $tokenId): Token
    {
        try {
            /** @var TokenDataMapper $tokenDataMapper */
            $tokenDataMapper = $this->createQueryBuilder('t')
                ->select('t')
                ->where('t.id = :id')
                ->setParameter('id', (string) $tokenId)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        if (empty($tokenDataMapper)) {
            throw new NotFoundException((string) ErrorMessage::TOKEN_NOT_FOUND());
        }

        return $tokenDataMapper->toToken();
    }

    /**
     * @throws InternalException
     * @throws NotFoundException
     */
    public function findWithUserIdAndType(UserId $userId, TokenType $tokenType): Token
    {
        try {
            /** @var TokenDataMapper $tokenDataMapper */
            $tokenDataMapper = $this->createQueryBuilder('t')
                ->select('t')
                ->where('t.userId = :userId')
                ->andWhere('t.type = :type')
                ->setParameter('userId', (string) $userId)
                ->setParameter('type', (string) $tokenType)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        if (empty($tokenDataMapper)) {
            throw new NotFoundException((string) ErrorMessage::TOKEN_NOT_FOUND());
        }

        return $tokenDataMapper->toToken();
    }
}
