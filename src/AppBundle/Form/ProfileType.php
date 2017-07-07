<?php

namespace AppBundle\Form;

use AppBundle\Entity\Mobility;
use AppBundle\Entity\UserMobility;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstname', TextType::class,
                array(
                    'label' => 'Prénom',
                    'attr' => array(
                        'placeholder' => 'Entrez votre prénom'
                    )
                )
            )
            ->add(
                'lastname', TextType::class,
                array(
                    'label' => 'Nom de famille',
                    'attr' => array(
                        'placeholder' => 'Entrez votre nom de famille'
                    )
                )
            )
            ->add(
                'title', TextType::class,
                array(
                    'label' => 'Titre',
                    'attr' => array(
                        'placeholder' => 'Entrez votre titre'
                    )
                )
            )
            ->add(
                'wantedJob', TextType::class,
                array(
                    'label' => 'Poste désiré',
                    'attr' => array(
                        'placeholder' => 'Entrez votre poste désiré'
                    )
                )
            )
            ->add(
                'mobility', ChoiceType::class, array(
                    'label' => 'Mobilité',
                    'attr' => array(
                        'placeholder' => 'Choisissez les régions ou vous êtes mobile'
                    ),
                    'choices' => $options['regions'],
                    'multiple' => true
                )
            )
            ->add(
                'experience', TextType::class,
                array(
                    'label' => 'Expérience',
                    'attr' => array(
                        'placeholder' => 'Entrez votre expérience en année'
                    )
                )
            )
            ->add(
                'salary', TextType::class,
                array(
                    'label' => 'Salaire actuel',
                    'attr' => array(
                        'placeholder' => 'Entrez votre salaire actuel'
                    ),
                    'required' => false
                )
            )
            ->add(
                'wantedSalary', TextType::class,
                array(
                    'label' => 'Salaire désiré',
                    'attr' => array(
                        'placeholder' => 'Entrez votre salaire désiré'
                    ),
                    'required' => false
                )
            )
            ->add(
                'phone', TextType::class,
                array(
                    'label' => 'Numéro de téléphone',
                    'attr' => array(
                        'placeholder' => 'Entrez votre numéro de téléphone'
                    )
                )
            )
            ->add(
                'submit', SubmitType::class,
                array(
                    'label' => 'Modifier',
                    'attr' => array(
                        'class' => 'btn blue'
                    )
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'regions' => null
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_profile_type';
    }
}
