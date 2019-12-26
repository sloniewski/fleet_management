<?php

namespace App\Entity\Dictionaries;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Dictionary;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EngineVolumeRepository")
 */
class EngineVolume extends Dictionary
{

}