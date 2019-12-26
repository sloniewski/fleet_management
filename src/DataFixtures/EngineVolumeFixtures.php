<?php

namespace App\DataFixtures;

use App\Entity\Dictionaries\EngineVolume;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class EngineVolumeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $options = [
            '1.0', '1.1', '1.2', '1.3', '1.4', '1.5', '1.6' , '1.7', '1.8', '1.9',
            '2.0', '2.1', '2.2', '2.3', '2.4', '2.5', '2.6',  '2.7', '2.8', '2.9',
            '3.0', '3.1', '3.2', '3.3', '3.4', '3.5', '3.6',  '3.7', '3.8', '3.9',
        ];

        foreach($options as $option) {
            $engine_volume = new EngineVolume();
            $engine_volume->setValue($option);
            $manager->persist($engine_volume);
        }

        $manager->flush();
    }
}
