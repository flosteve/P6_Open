<?php
/**
 * Created by PhpStorm.
 * User: EravilleSteve
 * Date: 15/03/2018
 * Time: 09:46
 */

namespace AppBundle\Form;


use AppBundle\Entity\Congregation;
use AppBundle\Entity\User;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends  AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('congregation', EntityType::class, [
            'class' => Congregation::class,
            'choice_label' => 'name',
            'placeholder' => 'Choisis ta congrégation',
            'attr' => [
                'class' => 'form-control selectpicker',
                'date-style' => 'select-with-transition'
            ]

        ])
            ->add('invitation', InvitationType::class, [
                'label' => 'Code Invitation',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Saisis ton code Invitation'
                ]
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'FRERE' => 'FRERE',
                    'SOEUR' => 'SOEUR'
                ],
                'attr' => [
                    'class' => 'form-control selectpicker',
                    'date-style' => 'select-with-transition'
                ]
            ])
            ->add('phoneNumber', PhoneNumberType::class, [
                'default_region' => 'FR',
                'format' => PhoneNumberFormat::NATIONAL,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Numéro de mobile'
                ]
            ])
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getName()
    {
        return 'app_user_registration';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

}