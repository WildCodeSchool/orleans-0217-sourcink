<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title', TextType::class,
                array(
                    'label' => 'Titre',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez le titre du produit',
                        )
                )
            )
            ->add(
                'text', TextareaType::class,
                array(
                    'label' => 'Description',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez la description du produit',
                            'class' => 'materialize-textarea'
                        )
                )
            )
            ->add(
                'price', IntegerType::class,
                array(
                    'label' => 'Prix',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez le prix du produit',
                        )
                )
            )
            ->add('category')
            ->add('picture', PictureType::class)
            ->add(
                'submit', SubmitType::class,
                array(
                    'label' => 'Enregistrer',
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
            'data_class' => 'AppBundle\Entity\Product'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product';
    }


}
