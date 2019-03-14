<?php
declare(strict_types=1);

namespace App\PlayerAccountManagement\Infrastructure\Doctrine\Adapter;

use App\PlayerAccountManagement\Domain\Entity\Token;
use App\PlayerAccountManagement\Domain\Port\TokenReader;
use App\PlayerAccountManagement\Domain\Port\TokenWriter;
use App\PlayerAccountManagement\Domain\ValueObject\PlayerId;
use App\PlayerAccountManagement\Domain\ValueObject\TokenId;
use App\PlayerAccountManagement\Domain\ValueObject\TokenType;
use App\Shared\Infrastructure\Doctrine\Exception\NotFoundException;
use App\PlayerAccountManagement\Infrastructure\Doctrine\Exception\ErrorMessage;
use App\PlayerAccountManagement\Infrastructure\Doctrine\TokenDataMapper;
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
    public function findWithPlayerIdAndType(PlayerId $playerId, TokenType $tokenType): Token
    {
        try {
            /** @var TokenDataMapper $tokenDataMapper */
            $tokenDataMapper = $this->createQueryBuilder('t')
                ->select('t')
                ->where('t.playerId = :playerId')
                ->andWhere('t.type = :type')
                ->setParameter('playerId', (string) $playerId)
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
