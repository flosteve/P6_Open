<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\ListUsersToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\DataTransformer\InvitationToCodeTransformer;

class GroupInvitationType extends AbstractType
{
    private $listUsersToArrayTransformer;

    public function __construct(ListUsersToArrayTransformer $listUsersToArrayTransformer)
    {
        $this->listUsersToArrayTransformer = $listUsersToArrayTransformer;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('emails', TextareaType::class, [
            'label' => 'Liste de diffusion',
            'attr' => [
                'placeholder' => 'Saisissez les emails des nouveaux utilisateurs séparés par des (;)',
                'class' => 'form-control',
                'rows' => 10,
                'cols' => 50
            ]
        ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary btn-round'
                ]
            ])
        ;

        $builder->get('emails')
            ->addModelTransformer($this->listUsersToArrayTransformer);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ListNewUsers',
            'required' => true
        ));
    }

}
