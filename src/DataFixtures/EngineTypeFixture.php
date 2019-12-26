<?php

namespace App\DataFixtures;

use App\Entity\Dictionaries\EngineType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class EngineTypeFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $engine_types = [
            'petrol',
            'diesel',
            'electric',
            'hybrid',
            'hybrid diesel'
        ];

        foreach($engine_types as $engine_type) {
            $type = new EngineType();
            $type->setValue($engine_type);
            $manager->persist($type);
        }

        $manager->flush();
    }
}
