<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname')
            ->add('lastname')
            ->add('title')
            ->add('currentJob')
            ->add('wantedJob')
            ->add(
                'mobility', ChoiceType::class, array(
                    'choices' => $options['mobility']
                )
            )
            ->add('experience')
            ->add('salary')
            ->add('wantedSalary')
            ->add('phone')
            ->add('submit', SubmitType::class, array('label' => 'Modifier'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'mobility' => ''
            )
        );
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_profile_type';
    }
}
