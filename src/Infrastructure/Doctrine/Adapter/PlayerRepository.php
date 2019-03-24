<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Adapter;

use App\Domain\GameManagement\Entity\Player;
use App\Domain\GameManagement\Port\PlayerReader;
use App\Domain\GameManagement\Port\PlayerWriter;
use App\Domain\GameManagement\ValueObject\PlayerId;
use App\Domain\GameManagement\ValueObject\PlayerName;
use App\Infrastructure\Doctrine\Exception\ErrorMessage;
use App\Infrastructure\Doctrine\PlayerDataMapper;
use App\Infrastructure\Shared\Doctrine\Exception\NotFoundException;
use App\Infrastructure\Shared\Exception\InternalException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Ramsey\Uuid\Uuid;

final class PlayerRepository extends ServiceEntityRepository implements PlayerReader, PlayerWriter
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerDataMapper::class);
    }

    public function isNameAlreadyUsed(PlayerName $playerName): bool
    {
        $result = $this->createQueryBuilder('p')
            ->select('p.name')
            ->where('p.name = :name')
            ->setParameter('name', (string) $playerName)
            ->getQuery()
            ->getResult();

        return (!empty($result));
    }

    /**
     * @throws InternalException
     * @throws NotFoundException
     */
    public function get(PlayerId $playerId): Player
    {
        try {
            /** @var PlayerDataMapper $playerDataMapper */
            $playerDataMapper = $this->createQueryBuilder('p')
                ->select('p')
                ->where('p.id = :id')
                ->setParameter('id', Uuid::fromString((string) $playerId))
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }

        if (empty($playerDataMapper)) {
            throw new NotFoundException((string) ErrorMessage::PLAYER_NOT_FOUND());
        }

        return $playerDataMapper->toPlayer();
    }

    /**
     * @throws InternalException
     */
    public function add(Player $player): void
    {
        $playerDataMapper = new PlayerDataMapper($player);

        try {
            $this->_em->persist($playerDataMapper);
            $this->_em->flush($playerDataMapper);
        } catch (ORMException $e) {
            throw new InternalException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
