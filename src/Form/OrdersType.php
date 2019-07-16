<?php

namespace App\Form;

use App\Entity\Orders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('OrderingNumber', TextType::class, [
                'required'  => true,
                'label'     => 'Numéro de commande',
                'attr'      => array('class' => 'form-control scanner_input')

            ])
            ->remove('VirLocalNumber')
            ->add('CustomerName', TextType::class, [
                'required'  => true,
                'label'     => 'Nom du destinataire',
                'attr'      => array('class' => 'form-control')

            ])
            ->remove('DateEntry')
            ->add('DelivryDate', DateType::class, array(
                'required'  => true,
                'label'     => 'Date de livraison : ',
                'widget'    =>'single_text',
                'attr'      => array('class' => 'form-control datepicker', 'readonly' => 'readonly'))
                    )
            ->add('Labels', IntegerType::class, array(
                'required' => true,
                'label' => 'Nombre de supports',
                'attr'      => array('class' => 'form-control')

            ))
            ->remove('User')
            ->remove('OrderStatus')
            ->add('productListings', CollectionType::class, array(
                'entry_type'   => ProductListingType::class,
                'allow_add'    => true,
                'allow_delete' => true
            ))
            ->add('save',      SubmitType::class, [
                'label' => 'Enregister les entrées',
                'attr'  => ['class' => 'btn btn-success']
            ])
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
