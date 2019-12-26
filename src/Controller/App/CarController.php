<?php

namespace App\Controller\App;

use App\Entity\Car;
use App\Form\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        $cars = $this->cars->findAll();
        return $this->render('app/car/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET"})
     */
    public function new(Request $request)
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($form->getData());
            $manager->flush();
            return $this->redirectToRoute('cars_index');
        }

        return $this->render('app/car/new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }
}
