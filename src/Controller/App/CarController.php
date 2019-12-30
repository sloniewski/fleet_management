<?php

namespace App\Controller\App;

use App\Entity\Car;
use App\Entity\Brand;
use App\Form\CarType;
use App\Repository\ModelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $form = $this->getForm($car);
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

    private function getForm(Car $car): FormInterface
    {
        $form = $this->createForm(CarType::class, $car);
        $form->add('brand', EntityType::class, [
            'class' => Brand::class,
            'mapped' => false,
            'choice_label' => 'name'
        ]);
        $form->add('model_name', ChoiceType::class, [
           'choices' => [],
            'mapped' => false,
        ]);
        return $form;
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

        $models = $this->getModelsForBrand($brand);
        foreach($models as $model) {
            $data['results'][] = ['id' => $model['name'], 'text' => $model['name']];
        }

        return (new JsonResponse($data));
    }

    private function getModelsForBrand(Brand $brand)
    {
        return $this->models->createQueryBuilder('models')
            ->select('models.name, models.brand_id')
            ->groupBy('models.name, models.brand_id')
            ->having("models.brand_id = :brand_id")
            ->setParameter('brand_id', $brand->getId())
            ->getQuery()
            ->getResult();
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
