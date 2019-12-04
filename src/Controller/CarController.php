<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;


/**
 * Class CarController
 * @package App\Controller
 * @Route("/cars", name="cars_")
 */
class CarController extends AbstractController
{
    private $cars;

    public function __construct(CarRepository $carRepository)
    {
        $this->cars = $carRepository;
    }

    /**
     * @Route("/at-repair", name="at_repair", methods={"GET"})
     */
    public function indexAtRepair()
    {
        $cars = $this->cars->findAll();
        return $this->render('app/car/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    /**
     * @Route("/in-service", name="in_service", methods={"GET"})
     */
    public function indexInService()
    {
        $cars = $this->cars->findAll();
        return $this->render('app/car/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    /**
     * @Route("/", name="all", methods={"GET"})
     */
    public function index()
    {
        $cars = $this->cars->findAll();
        return $this->render('app/car/index.html.twig', [
            'cars' => $cars,
        ]);
    }
}
