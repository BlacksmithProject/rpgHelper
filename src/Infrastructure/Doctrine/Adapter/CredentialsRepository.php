<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Adapter;

use App\Domain\CredentialsManagement\Entity\Credentials;
use App\Domain\CredentialsManagement\Port\CredentialsReader;
use App\Domain\CredentialsManagement\Port\CredentialsWriter;
use App\Domain\CredentialsManagement\ValueObject\Email;
use App\Domain\CredentialsManagement\ValueObject\CredentialsId;
use App\Infrastructure\Shared\Doctrine\Exception\NotFoundException;
use App\Infrastructure\Doctrine\Exception\ErrorMessage;
use App\Infrastructure\Doctrine\CredentialsDataMapper;
use App\Infrastructure\Shared\Exception\InternalException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Ramsey\Uuid\Uuid;

final class CredentialsRepository extends ServiceEntityRepository implements CredentialsReader, CredentialsWriter
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CredentialsDataMapper::class);
    }

    public function isEmailAlreadyUsed(Email $email): bool
    {
        $result = $this->createQueryBuilder('p')
            ->select('p.email')
            ->where('p.email = :email')
            ->setParameter('email', (string) $email)
            ->getQuery()
            ->getResult();

        return (!empty($result));
    }

    /**
     * @throws InternalException
     * @throws NotFoundException
     */
    public function get(CredentialsId $credentialsId): Credentials
    {
        try {
            /** @var CredentialsDataMapper $credentialsDataMapper */
            $credentialsDataMapper = $this->createQueryBuilder('p')
                ->select('p')
                ->where('p.id = :id')
                ->setParameter('id', Uuid::fromString((string) $credentialsId))
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        if (empty($credentialsDataMapper)) {
            throw new NotFoundException((string) ErrorMessage::CREDENTIALS_NOT_FOUND());
        }

        return $credentialsDataMapper->toCredentials();
    }

    /**
     * @throws InternalException
     */
    public function add(Credentials $credentials): void
    {
        $credentialsDataMapper = new CredentialsDataMapper($credentials);

        try {
            $this->_em->persist($credentialsDataMapper);
            $this->_em->flush($credentialsDataMapper);
        } catch (ORMException $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws InternalException
     * @throws NotFoundException
     */
    public function findWithEmail(Email $email): Credentials
    {
        try {
            /** @var CredentialsDataMapper $credentialsDataMapper */
            $credentialsDataMapper = $this->createQueryBuilder('p')
                ->select('p')
                ->where('p.email = :email')
                ->setParameter('email', (string) $email)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        if (empty($credentialsDataMapper)) {
            throw new NotFoundException((string) ErrorMessage::CREDENTIALS_NOT_FOUND());
        }

        return $credentialsDataMapper->toCredentials();
    }
}
