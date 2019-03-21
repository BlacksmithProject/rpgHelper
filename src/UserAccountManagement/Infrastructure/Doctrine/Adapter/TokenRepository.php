<?php
declare(strict_types=1);

namespace App\UserAccountManagement\Infrastructure\Doctrine\Adapter;

use App\UserAccountManagement\Domain\Entity\Token;
use App\UserAccountManagement\Domain\Port\TokenReader;
use App\UserAccountManagement\Domain\Port\TokenWriter;
use App\UserAccountManagement\Domain\ValueObject\UserId;
use App\UserAccountManagement\Domain\ValueObject\TokenId;
use App\UserAccountManagement\Domain\ValueObject\TokenType;
use App\Shared\Infrastructure\Doctrine\Exception\NotFoundException;
use App\UserAccountManagement\Infrastructure\Doctrine\Exception\ErrorMessage;
use App\UserAccountManagement\Infrastructure\Doctrine\TokenDataMapper;
use App\Shared\Infrastructure\Exception\InternalException;
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
