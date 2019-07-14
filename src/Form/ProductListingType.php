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
                'label'     => 'Numéro de parcelle ou de produit',
                'attr'      => array('class' => 'form-control')

            ])
            ->remove('OrderNumber')
            ->add('FamilyProduct', EntityType::class, [
                'class' => FamilyProduct::class,
                'expanded' => true,
                'multiple' => false,
                'label'     => 'Type d\'ajout',
                'attr'      => array('class' => 'text-center custom_radio')
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
