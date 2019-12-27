<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year')
            ->add('model', EntityType::class, [
                'class' => Model::class,
                'choice_label' => function ($choice, $key, $value) {
                    return "{$key} {$choice->getName()} {$choice->getYear()} {$choice->getEngineVolume()->getValue()}";
                },
                'choices' => []
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
