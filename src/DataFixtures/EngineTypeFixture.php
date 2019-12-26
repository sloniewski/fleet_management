<?php

namespace App\DataFixtures;

use App\Entity\Dictionaries\EngineType;
use App\Repository\EngineTypeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class EngineTypeFixture extends Fixture
{
    private $engineTypes;

    public function __construct(EngineTypeRepository $engineTypes)
    {
        $this->engineTypes = $engineTypes;
    }

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
            $type = $this->firstOrNew($engine_type);
            $type->setValue($engine_type);
            $manager->persist($type);
        }

        $manager->flush();
    }

    private function firstOrNew(string $engine_type)
    {
        $type = $this->engineTypes->findByType($engine_type);
        return $type ? $type : new EngineType();
    }
}
