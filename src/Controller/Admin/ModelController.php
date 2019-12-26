<?php


namespace App\Controller\Admin;

use App\Entity\Model;
use App\Form\ModelType;
use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BrandController
 * @package App\Controller\Admin
 * @Route("/admin/models", name="admin_models_")
 */
class ModelController extends AbstractController
{
    private $models;

    public function __construct(ModelRepository $models)
    {
        $this->models = $models;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        $models = $this->models->findAll();

        return $this->render('admin/models/index.html.twig', [
            'models' => $models
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);
        $manager = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();
            return $this->redirectToRoute('admin_models_index');
        }

        return $this->render('admin/models/new.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }
}