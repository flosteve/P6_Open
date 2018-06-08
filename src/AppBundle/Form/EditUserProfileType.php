<?php
/**
 * Created by PhpStorm.
 * User: EravilleSteve
 * Date: 30/10/2017
 * Time: 14:55
 */

namespace AppBundle\Form;


use AppBundle\Entity\Congregation;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $roles =  ['Role User ' => 'ROLE_USER',
            'Role Admin ' => 'ROLE_ADMIN'
        ];


        $builder
            ->remove('plainPassword')
            ->add('email', EmailType::class)
            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'choices' => $roles,
                'multiple' => true,
                'attr' => [
                    'class' => 'selectpicker'
                ]
            ])
            ->add('congregation', EntityType::class, [
                'class' => Congregation::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisis ta congrégation',
                'attr' => [
                    'class' => 'form-control selectpicker',
                    'date-style' => 'select-with-transition'
                ]

            ])

 ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}