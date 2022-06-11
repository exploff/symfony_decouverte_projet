<?php

namespace ClubBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ActiviteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre', TextType::class)
                ->add('description', TextType::class)
                ->add('club', EntityType::class, array(
                    'class'         =>  'ClubBundle:Club',
                    'choice_label'  =>  'nom',
                    'multiple'      =>  false,
                    'required'      =>  true
                ))
                ->add('adherents', EntityType::class, array(
                    'class'         =>  'ClubBundle:Adherent',
                    'choice_label'  =>  'PrenomNom',
                    'multiple'      =>  true,
                    'required'      =>  false,
                    'expanded'      =>  true
                ))
                ->add('Valider', SubmitType::class, array('label' => 'valider'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClubBundle\Entity\Activite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'clubbundle_activite';
    }


}
