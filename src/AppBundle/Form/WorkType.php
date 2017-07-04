<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name', TextType::class,
                array(
                    'label' => 'Nom',
                    'attr' =>
                        array(
                            'placeholder' => 'Entrez le nom du métier',
                        )
                )
            )
            ->add('category')
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
                'data_class' => 'AppBundle\Entity\Work'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_work';
    }


}
