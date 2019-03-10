<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Player\Adapter;

use App\Domain\PlayerAccountManagement\Entity\Token;
use App\Domain\PlayerAccountManagement\Port\TokenReader;
use App\Domain\PlayerAccountManagement\Port\TokenWriter;
use App\Domain\PlayerAccountManagement\ValueObject\PlayerId;
use App\Domain\PlayerAccountManagement\ValueObject\TokenId;
use App\Domain\PlayerAccountManagement\ValueObject\TokenType;
use App\Infrastructure\Doctrine\Exception\NotFoundException;
use App\Infrastructure\Doctrine\Player\Exception\ErrorMessage;
use App\Infrastructure\Doctrine\Player\TokenDataMapper;
use App\Infrastructure\Exception\InternalException;
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
