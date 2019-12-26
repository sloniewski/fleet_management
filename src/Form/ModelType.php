<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Dictionaries\EngineType;
use App\Entity\Dictionaries\EngineVolume;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('year')
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name'
            ])
            ->add('engineType', EntityType::class, [
                'class' => EngineType::class,
                'choice_label' => 'value'
            ])
            ->add('engineVolume', EntityType::class, [
                'class' => EngineVolume::class,
                'choice_label' => 'value'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Model::class,
        ]);
    }
}
