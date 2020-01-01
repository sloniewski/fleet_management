<?php

namespace App\Controller\FleetManager;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class HomeController
 * @package App\Controller\FleetManager
 * @IsGranted("ROLE_USER")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('fleet-manager/home.html.twig');
    }
}