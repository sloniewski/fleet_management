<?php

namespace App\Repository;

use \App\Entity\Dictionaries\EngineVolume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EngineVolume|null find($id, $lockMode = null, $lockVersion = null)
 * @method EngineVolume|null findOneBy(array $criteria, array $orderBy = null)
 * @method EngineVolume[]    findAll()
 * @method EngineVolume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EngineVolumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EngineVolume::class);
    }

    public function findByVolume($type) : ?EngineVolume
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.value = :val')
            ->setParameter('val', $type)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
