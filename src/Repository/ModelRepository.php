<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\Model;

/**
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelRepository extends AbstractRepository
{
    protected $entityClass = Model::class;
    protected $alias = 'models';

    public function filterByBrand(Brand $brand): self
    {
        $this->builder = $this->getBuilder()
            ->andWhere("{$this->alias}.brand_id = :brand_id")
            ->setParameter('brand_id', $brand->getId());

        return $this;
    }
}
