<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class BrandController
 * @package App\Controller\Admin
 * @Route("/admin/brands", name="admin_brands_")
 */
class BrandController extends AbstractController
{
    /**
     * @var BrandRepository
     */
    private $brands;

    /**
     * BrandController constructor.
     * @param BrandRepository $brands
     */
    public function __construct(BrandRepository $brands)
    {
        $this->brands = $brands;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('admin/brands/index.html.twig', [
            'brands' => $this->brands->findAll()
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $model = new Brand();
        $form = $this->createForm(BrandType::class, $model);

        if($form->isSubmitted() && $form->isValid()) {
            var_dump('x');
        }
        return $this->render('admin/brands/new.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }
}