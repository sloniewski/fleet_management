<?php

namespace App\Controller\FleetManager;

use App\Entity\Car;
use App\Entity\Brand;
use App\Form\CarType;
use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;


/**
 * Class CarController
 * @package App\Controller
 * @Route("/cars", name="cars_")
 */
class CarController extends AbstractController
{
    /**
     * @var CarRepository
     */
    private $cars;

    /**
     * @var ModelRepository
     */
    private $models;

    public function __construct(CarRepository $carRepository, ModelRepository $modelRepository)
    {
        $this->cars = $carRepository;
        $this->models = $modelRepository;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        $cars = $this->cars->findAll();
        return $this->render('fleet-manager/car/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
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

        return $this->render('fleet-manager/car/new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Car $car): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return $this->redirectToRoute('cars_index');
        }

        return $this->render('fleet-manager/car/edit.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Endpoint for ajax calls
     * @Route("/brand-models/{id}", name="brand_model_names", methods={"GET"})
     * @param Brand $brand
     * @return JsonResponse
     */
    public function modelNames(Brand $brand): JsonResponse
    {
        $data = [
            "results" => [
            ],
            "pagination" => [
                "more" => false
            ]
        ];

        $models = $this->models->getDistinctModelNames($brand);
        foreach($models as $model) {
            $data['results'][] = ['id' => $model->getName(), 'text' => $model->getName()];
        }

        return (new JsonResponse($data));
    }

    /**
     * Endpoint for ajax calls
     * @Route("/models/{id}", name="brand_models", methods={"GET"})
     * @param Brand $brand
     * @param Request $request
     * @return JsonResponse
     */
    public function models(Brand $brand, Request $request): JsonResponse
    {
        $data = [
            "results" => [
                [ 'id' => 0, 'text' => '---' ]
            ],
            "pagination" => [
                "more" => false
            ]
        ];

        $models = $this->models
            ->filterByBrand($brand)
            ->filterByName($request->get('brand_model', 0))
            ->get();

        foreach($models as $model) {
            $data["results"][] = [
                'id' => $model->getId(),
                'text' => "{$model->getEngineVolume()->getValue()} {$model->getEngineType()->getValue()}, year {$model->getYear()}"
            ];
        }

        return (new JsonResponse($data));
    }
}
