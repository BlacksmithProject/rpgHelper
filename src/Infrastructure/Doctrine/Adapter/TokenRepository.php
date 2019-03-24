<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Adapter;

use App\Domain\CredentialsManagement\Entity\Token;
use App\Domain\CredentialsManagement\Port\TokenReader;
use App\Domain\CredentialsManagement\Port\TokenWriter;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;
use App\Domain\CredentialsManagement\ValueObject\TokenId;
use App\Domain\CredentialsManagement\ValueObject\TokenType;
use App\Infrastructure\Shared\Doctrine\Exception\NotFoundException;
use App\Infrastructure\Doctrine\Exception\ErrorMessage;
use App\Infrastructure\Doctrine\TokenDataMapper;
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
    public function findWithCredentialsIdAndType(CredentialsId $credentialsId, TokenType $tokenType): Token
    {
        try {
            /** @var TokenDataMapper $tokenDataMapper */
            $tokenDataMapper = $this->createQueryBuilder('t')
                ->select('t')
                ->where('t.credentialsId = :credentialsId')
                ->andWhere('t.type = :type')
                ->setParameter('credentialsId', (string) $credentialsId)
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
