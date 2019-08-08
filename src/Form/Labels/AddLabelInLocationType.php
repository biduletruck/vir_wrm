<?php

namespace App\Form\Labels;

use App\Entity\Labels;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddLabelInLocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('localLabel', TextType::class, [
                'required'  => true,
                'label' => 'Numéro de support',
                'attr' => [
                    'class' => 'form-control scanner_input']
            ])
            ->remove('LocationDate')
            ->remove('virLocalNumber')
            ->remove('location')
            ->add('newLocation', TextType::class, [
                'required'  => true,
                'label' => 'Emplacement',
                'attr' => [
                    'class' => 'form-control scanner_input']
            ])
            ->add('lice', IntegerType::class, [
                'required'  => true,
                'label' => 'Hauteur (Lice)',
                'attr' => [
                    'class' => 'form-control scanner_input']
            ])
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
