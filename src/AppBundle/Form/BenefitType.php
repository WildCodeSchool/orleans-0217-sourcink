<?php

namespace AppBundle\Form;

use AppBundle\Entity\ProductOption;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BenefitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'description', TextareaType::class,
                array(
                    'label' => 'Description',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez une description de l\'option',
                            'class' => 'materialize-textarea'
                        )
                )
            )
            ->add(
                'productOptions', CollectionType::class, [
                'entry_type'=> ProductOptionType::class,
                ]
            )
            ->add(
                'submit', SubmitType::class,
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
            'data_class' => 'AppBundle\Entity\Benefit'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_benefit';
    }

}
