<?php

namespace App\Repository\Events;

use App\Entity\TechnicalInspection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TechnicalInspection|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnicalInspection|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnicalInspection[]    findAll()
 * @method TechnicalInspection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnicalInspectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnicalInspection::class);
    }

    // /**
    //  * @return TechnicalInspection[] Returns an array of TechnicalInspection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TechnicalInspection
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
