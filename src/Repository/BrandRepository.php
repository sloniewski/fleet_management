<?php

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Brand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brand[]    findAll()
 * @method Brand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandRepository extends AbstractRepository
{
    protected $entityClass = Brand::class;
    protected $alias = 'brands';

    public function filterById($id): self
    {
        $this->builder = $this->getBuilder()
            ->andWhere("{$this->alias}.id = :id")
            ->setParameter("id", $id);

        return $this;
    }
}
