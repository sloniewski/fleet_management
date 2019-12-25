<?php

namespace App\Controller\Admin;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CarController
 * @package App\Controller
 * @Route("/admin/cars", name="admin_cars_")
 */
class CarController extends AbstractController
{

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(CarRepository $cars)
    {
        return $this->render('admin/cars/index.html.twig');
    }

}