<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddLocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Allee',  TextType::class, ['attr' => ['placeholder' => 'Nom']])
            ->add('Lice', NumberType::class, ['attr' => ['placeholder'=> 'Nombre de lices']])
            ->add('Aveole', NumberType::class, ['attr' => ['placeholder'=> 'Nombre d\'avéoles']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
