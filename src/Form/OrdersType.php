<?php

namespace App\Form;

use App\Entity\Orders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('OrderingNumber')
            ->remove('VirLocalNumber')
            ->add('CustomerName')
            ->remove('DateEntry')
            ->add('DelivryDate')
            ->remove('User')
            ->add('productListings', CollectionType::class, array(
                'entry_type'   => ProductListingType::class,
                'allow_add'    => true,
                'allow_delete' => true
            ))
            ->add('save',      SubmitType::class)
    ;
    }

      public function configureOptions(OptionsResolver $resolver)
      {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
      }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'orders_new';
    }
}
