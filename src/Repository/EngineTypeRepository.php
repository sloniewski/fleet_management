<?php

namespace App\Repository;

use \App\Entity\Dictionaries\EngineType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EngineType|null find($id, $lockMode = null, $lockVersion = null)
 * @method EngineType|null findOneBy(array $criteria, array $orderBy = null)
 * @method EngineType[]    findAll()
 * @method EngineType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EngineTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EngineType::class);
    }

    public function findByType($type) : ?EngineType
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.value = :val')
            ->setParameter('val', $type)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
