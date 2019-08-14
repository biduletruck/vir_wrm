<?php

namespace App\Form;

use App\Entity\FamilyProduct;
use App\Entity\ProductListing;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductListingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ProductNumber', TextType::class, [
                'required'  => true,
                'label' => false,
                'attr'      => array(
                    'class' => 'form-control',
                    'placeholder'     => 'Numero de colis'
                )

            ])
            ->remove('OrderNumber')
            ->add('FamilyProduct', EntityType::class, [
                'class' => FamilyProduct::class,
                'expanded' => true,
                'label' => false,
                'multiple' => false,
                'placeholder'     => 'Type',
                'attr'      => array('class' => 'toggle form-check')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductListing::class,
        ]);
    }
}
