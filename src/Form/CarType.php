<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\Color;
use App\Entity\Model;
use App\Repository\AbstractRepository;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    private $models;
    private $brands;

    public function __construct(ModelRepository $models, BrandRepository $brands)
    {
        $this->models = $models;
        $this->brands = $brands;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year')
            ->add('plates')
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'choice_label' => 'name',
                'choice_attr' => function($color, $key, $index) {
                    return ['data-color' => $color->getHexRgb()];
                },
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT,[$this, 'onPreSubmit'])
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }

    /**
     * @param FormEvent $event
     */
    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $car = $event->getData();

        $this->addDynamicFields($form, $car);
    }

    /**
     * @param FormEvent $event
     */
    public function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $car = $event->getData();

        $this->addDynamicFields($form, $car);
    }

    private function addDynamicFields(FormInterface $form, $car) {
        $this->addModels($form, $car);
        $this->addBrand($form, $car);
        $this->addModelNames($form, $car);
    }

    public function addBrand(FormInterface $form, $car)
    {
        $brand = ($car instanceof Car) ? $car->getBrand() : null;

        $form->add('brand', EntityType::class, [
            'class' => Brand::class,
            'choice_label' => 'name',
            'required' => false,
            'data' => $brand,
            'mapped' => false,
        ]);
    }

    /**
     * @param FormInterface $form
     * @param $car
     */
    private function addModelNames(FormInterface $form, $car)
    {
        $brand = ($car instanceof Car) ? $car->getBrand() : null;

        $choices = [];
        $models = $this->models->buildQuery()->getDistinctModelNames($brand);
        foreach($models as $model) {
            $choices[$model['name']] = $model['name'];
        }

        $form->add('model_name', ChoiceType::class, [
            'mapped' => false,
            'required' => false,
            'choices' => $choices,
            'data' => ($car instanceof Car && $car->getModel()) ? $car->getModel()->getName() : null,
        ]);
    }

    /**
     * @param FormInterface $form
     * @param $car
     */
    private function addModels(FormInterface $form, $car = null)
    {
        $brand = null;
        if($car instanceof Car) {
            $brand = $car->getBrand();
        }
        if (is_array($car) && array_key_exists('brand', $car)) {
            $brand = $car['brand'];
        }

        if($brand) $brand = $this->brands->filterById($brand)->first();

        $form->add('model', EntityType::class, [
            'class' => Model::class,
            'choice_label' => function ($model, $key, $value) {
                return "{$model->getEngineVolume()->getValue()} {$model->getEngineType()->getValue()}, year {$model->getYear()}";
            },
            'choices' => $brand ? $this->models->buildQuery()->filterByBrand($brand)->get() : [],
        ]);
    }
}
