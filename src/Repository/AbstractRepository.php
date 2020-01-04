<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class AbstractRepository extends ServiceEntityRepository
{
    protected $builder;
    protected $entityClass = null;
    protected $alias = null;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->entityClass);
    }

    public function getBuilder(): QueryBuilder
    {
        if(isset($this->builder)) return $this->builder;

        return $this->createQueryBuilder($this->alias);
    }

    /**
     * Gets the list of results for the query.
     * @return mixed
     */
    public function get()
    {
        return $this->getBuilder()
            ->getQuery()
            ->getResult();
    }

    public function first()
    {
        return $this->getBuilder()
        ->getQuery()
        ->getOneOrNullResult();
    }

    /**
     * @return AbstractRepository
     */
    public function buildQuery(): self
    {
        $this->builder = null;
        return $this;
    }
}
