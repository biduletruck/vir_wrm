<?php

namespace App\Form\Locations;

use App\Entity\Agencies;
use App\Entity\Locations;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('allee', TextType::class, [

                'label' => 'Nom de l\'allée',
                'attr'      => ['class' => 'form-control']
            ])
            ->add('lice', NumberType::class, [

                'label' => 'Nombre de lices (hauteur)',
                'attr'      => ['class' => 'form-control']
            ])
            ->add('alveole', NumberType::class, [

                'label' => 'Nombre d\'emplacements (alvéoles)',
                'attr'      => ['class' => 'form-control']
            ])
            ->add('agency', EntityType::class, [
                'required' => true,
                'label' => 'Nom de l\'agence',
                'class'   => Agencies::class,
                'attr'      => ['class' => 'form-control']
            ])
            ->add('send', SubmitType::class,[
                'label' => 'ajouter',
                'attr'      => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Locations::class,
        ]);
    }
}
