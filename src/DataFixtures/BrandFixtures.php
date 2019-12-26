<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $brands = [
            'skoda',
            'volkswagen',
            'toyota',
            'opel',
            'ford',
            'kia',
            'dacia',
            'hyundai',
        ];

        foreach($brands as $brand_name) {
            $brand = new Brand();
            $brand->setName($brand_name);
            $manager->persist($brand);
        }

        $manager->flush();
    }
}
