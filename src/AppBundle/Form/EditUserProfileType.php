<?php
/**
 * Created by PhpStorm.
 * User: EravilleSteve
 * Date: 30/10/2017
 * Time: 14:55
 */

namespace AppBundle\Form;


use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $congregation = ['Paris Anglaise Orly' => 'Paris Anglaise Orly',
            'Chevilly-Larue' => 'Chevilly-Larue',
            'Thiais' => 'Thiais',
            'Villejuif' => 'Villejuif',
            'Vitry-Sud' => 'Vitry-Sud',
            'Creteil-Lingala' => 'Creteil-Lingala'
        ];
        $roles =  ['Role User ' => 'ROLE_USER',
            'Role Admin ' => 'ROLE_ADMIN'
        ];


        $builder
//            ->remove('username')
            ->remove('plainPassword')
//            ->add('phoneNumber', PhoneNumberType::class, [
//                'label' => 'Téléphone',
//            ])
            ->add('email', EmailType::class)
            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'choices' => $roles,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('congregation', ChoiceType::class, [
                'label' => 'Congregation',
                'choices' => $congregation,

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