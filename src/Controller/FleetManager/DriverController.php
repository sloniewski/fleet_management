<?php

namespace App\Controller\FleetManager;

use App\Entity\Driver;
use App\Form\DriverType;
use App\Repository\DriverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class DriverController
 * @package App\Controller
 * @Route("/driver", name="driver_")
 */
class DriverController extends AbstractController
{
    private $drivers;

    public function __construct(DriverRepository $drivers)
    {
        $this->drivers = $drivers;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        $drivers = $this->drivers->findAll();

        return $this->render('fleet-manager/driver/index.html.twig', [
            'drivers' => $drivers,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
        $driver = new Driver();
        $form = $this->createForm(DriverType::class, $driver);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($form->getData());
            $manager->flush();
            return $this->redirectToRoute('driver_index');
        }

        return $this->render('fleet-manager/driver/new.html.twig', [
            'driver' => $driver,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Driver $driver): Response
    {
        return $this->render('fleet-manager/driver/show.html.twig', [
            'driver' => $driver,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET"})
     */
    public function edit(Driver $driver)
    {
        return $this->render('fleet-manager/driver/edit.html.twig');
    }

    /**
     * @Route("/{id}/add-car", name="add_car", methods={"GET", "POST"})
     */
    public function addCar(Driver $driver)
    {
        return $this->render('fleet-manager/driver/add-car.html.twig');
    }
}
