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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InviteUsersCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
         ->add('emails', TextareaType::class, [
             'label' => 'Emails',
             'attr' => [
                 'class' => 'form-control',
                 'placeholder' => 'Saisir les adresses emails des utilisateurs en les séparants par des ;'
             ]
         ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ])


;
    }

}