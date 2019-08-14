<?php

namespace App\Form;

use App\Entity\Agencies;
use App\Entity\Companies;
use App\Entity\Orders;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('Company', EntityType::class, array(
                'required' => false,
                'class'   => Companies::class,
                'attr'      => array('class' => 'form-control')
            ))
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
            ->remove('Agency')
            ->add('productListings', CollectionType::class, array(
                'entry_type'   => ProductListingType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'attr'      => array('class' => '')
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
