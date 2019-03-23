<?php
declare(strict_types=1);

namespace App\Infrastructure\UserAccountManagement\Doctrine\Adapter;

use App\Domain\UserAccountManagement\Entity\User;
use App\Domain\UserAccountManagement\Port\UserReader;
use App\Domain\UserAccountManagement\Port\UserWriter;
use App\Domain\UserAccountManagement\ValueObject\Email;
use App\Domain\UserAccountManagement\ValueObject\UserId;
use App\Domain\UserAccountManagement\ValueObject\UserName;
use App\Infrastructure\Shared\Doctrine\Exception\NotFoundException;
use App\Infrastructure\UserAccountManagement\Doctrine\Exception\ErrorMessage;
use App\Infrastructure\UserAccountManagement\Doctrine\UserDataMapper;
use App\Infrastructure\Shared\Exception\InternalException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Ramsey\Uuid\Uuid;

final class UserRepository extends ServiceEntityRepository implements UserReader, UserWriter
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDataMapper::class);
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

    public function isNameAlreadyUsed(UserName $userName): bool
    {
        $result = $this->createQueryBuilder('p')
            ->select('p.name')
            ->where('p.name = :name')
            ->setParameter('name', (string) $userName)
            ->getQuery()
            ->getResult();

        return (!empty($result));
    }

    /**
     * @throws InternalException
     * @throws NotFoundException
     */
    public function get(UserId $userId): User
    {
        try {
            /** @var UserDataMapper $userDataMapper */
            $userDataMapper = $this->createQueryBuilder('p')
                ->select('p')
                ->where('p.id = :id')
                ->setParameter('id', Uuid::fromString((string) $userId))
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        if (empty($userDataMapper)) {
            throw new NotFoundException((string) ErrorMessage::USER_NOT_FOUND());
        }

        return $userDataMapper->toUser();
    }

    /**
     * @throws InternalException
     */
    public function add(User $user): void
    {
        $userDataMapper = new UserDataMapper($user);

        try {
            $this->_em->persist($userDataMapper);
            $this->_em->flush($userDataMapper);
        } catch (ORMException $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws InternalException
     * @throws NotFoundException
     */
    public function findWithEmail(Email $email): User
    {
        try {
            /** @var UserDataMapper $userDataMapper */
            $userDataMapper = $this->createQueryBuilder('p')
                ->select('p')
                ->where('p.email = :email')
                ->setParameter('email', (string) $email)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        if (empty($userDataMapper)) {
            throw new NotFoundException((string) ErrorMessage::USER_NOT_FOUND());
        }

        return $userDataMapper->toUser();
    }
}
