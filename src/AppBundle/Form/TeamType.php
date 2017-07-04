<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                array(
                    'label' => 'Nom',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez le nom de la personne',
                        )
                ))
            ->add('text', TextareaType::class,
                array(
                    'label' => 'Description',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez la description de la personne',
                        )
                ))
            ->add('linkedin', TextType::class,
                array(
                    'label' => 'Linkedin',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez le lien vers la page Linkedin de la personne',
                        )
                ))
            ->add('picture', PictureType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => 'AppBundle\Entity\Team'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_team';
    }


}
