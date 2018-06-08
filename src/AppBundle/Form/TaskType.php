<?php
/**
 * Created by PhpStorm.
 * User: EravilleSteve
 * Date: 30/10/2017
 * Time: 14:55
 */

namespace AppBundle\Form;


use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
         ->add('name', TextType::class, [
             'label' => 'Nom',
             'attr' => [
                 'class' => 'form-control'
             ]
         ])
        ->add('description', TextType::class, [
             'label' => 'Description',
            'attr' => [
                'class' => 'form-control'
            ]
         ])
        ->add('frequence', TextType::class, [
            'label' => 'Fréquence',
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ->add('nextDate', DateTimeType::class, [
            'label' => 'Prochaine Intervention',
            'widget' => 'single_text',
            'html5' => false,
            'attr' => [
                'class' => 'form-control datetimepicker'
            ],
            'label_attr' => [
                'class' => 'label-control'
            ]
        ])
            ->add('users', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'multiple' => true,
                'placeholder' => 'Selectioner des Volontaire',
                'attr' => [
                    'class' => 'selectpicker'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ])
;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class
        ]);
    }
}