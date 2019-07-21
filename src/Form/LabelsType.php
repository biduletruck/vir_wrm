<?php

namespace App\Form;

use App\Entity\Labels;
use App\Entity\Locations;
use App\Repository\LocationsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LabelsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('localLabel')
            ->remove('LocationDate')
            ->remove('virLocalNumber')
            ->remove('location', EntityType::class, array(
                'required' => false,
                'class'   => Locations::class,
            ))
            ->add('newLocation', EntityType::class, array(
                'class'   => Locations::class,
                'query_builder' => function (LocationsRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->andWhere('f.FreePlace = 1');
                },
                'choice_label' => 'location',
              //  'mapped' => false,
            ))

            ->remove('Login')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Labels::class,
        ]);
    }
}
