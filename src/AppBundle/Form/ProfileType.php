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
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->remove('current_password')
            ->add('congregation', EntityType::class, [
            'class' => Congregation::class,
            'choice_label' => 'name',
            'placeholder' => 'Choisis ta congrégation',
            'attr' => [
                'class' => 'form-control selectpicker',
                'date-style' => 'select-with-transition'
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


        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getName()
    {
        return 'app_user_profile';
    }
}