<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeaderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                array(
                    'label' => 'Titre',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez le titre',
                        )
                )
            )
            ->add('text', TextType::class,
                array(
                    'label' => 'Sous-titre',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez le sous-titre',
                        )
                )
            )
            ->add('picture', PictureType::class)
            ->add('url', TextType::class,
                array(
                    'label' => 'Lien',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez le lien vers la page voulu',
                        )
                )
            )
            ->add('nameUrl', TextType::class,
                array(
                    'label' => 'Nom du lien',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez le nom du lien',
                        )
                )
            )
            ->add('submit', SubmitType::class,
                array(
                    'label'=>'Enregistrer',
                    'attr' =>
                        array(
                            'class' => 'btn blue'
                        )
                )
            );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => 'AppBundle\Entity\Header'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_header';
    }


}
