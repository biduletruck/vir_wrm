<?php

namespace App\Form\Users;

use App\Entity\Agencies;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('LastName', TextType::class, [
                'attr'      => array('class' => 'form-control')
            ])
            ->add('FirstName', TextType::class, [
                'attr'      => array('class' => 'form-control')
            ])
            ->add('Email', EmailType::class, [
                'attr'      => array('class' => 'form-control')
            ])
            ->add('Username', TextType::class, [
                'attr'      => array('class' => 'form-control')
            ])
            ->add('Password', PasswordType::class, [
                'attr'      => array('class' => 'form-control')
            ])
            ->add('Agency', EntityType::class, [
                'class' => Agencies::class,
                'required' => false,
                'attr'      => array('class' => 'form-control')
            ])
            ->add('Roles', ChoiceType::class, array(
                'label'  => 'Droit de l\'utilisateur' ,
                'expanded'  => true,
                'multiple'  => true,
                'attr'      => array('class' => 'form-check'),
                'choices'  => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ]
            ))
            ->add('Account', CheckboxType::class,[
                'label'  => 'Compte Actif ',
                'attr'      => array('class' => 'form-check')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}