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
                'choices' => array(
                    'Auvergne-Rhône-Alpes' => 'Auvergne-Rhône-Alpes',
                    'Bourgogne-Franche-Comté' => 'Bourgogne-Franche-Comté',
                    'Bretagne' => 'Bretagne',
                    'Centre-Val de Loire' => 'Centre-Val de Loire',
                    'Corse' => 'Corse',
                    'Grand Est' => 'Grand Est',
                    'Hauts-de-France' => 'Hauts-de-France',
                    'Île-de-France' => 'Île-de-France',
                    'Normandie' => 'Normandie',
                    'Nouvelle-Aquitaine' => 'Nouvelle-Aquitaine',
                    'Occitanie' => 'Occitanie',
                    'Pays de la Loire' => 'Pays de la Loire',
                    'Provence-Alpes-Côte d\'Azur' => 'Provence-Alpes-Côte d\'Azur',
                    'Guadeloupe' => 'Guadeloupe',
                    'Guyane' => 'Guyane',
                    'Martinique' => 'Martinique',
                    'Réunion' => 'Réunion',
                    'Mayotte' => 'Mayotte',
                    'Etranger - Union Européenne' => 'Etranger - Union Européenne',
                    'Etranger - Hors Union Européenne' => 'Etranger - Hors Union Européenne',
                )
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

    }
    public function getBlockPrefix()
    {
        return 'app_bundle_profile_type';
    }
}
