<?php

namespace AgenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class AchatType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('biens', EntityType::class, array(
                    'class'         =>  'AgenceBundle:Bien',
                    'choice_label'  =>  'nomBien',
                    'multiple'      =>  false,
                    'required'      =>  false,
                    'expanded'      =>  false
                ))
                ->add('dateAchat', DateType::class, array('years' => range(date('Y')-90, date('Y')+10)))
                ->add('proprietaires', EntityType::class, array(
                    'class'         =>  'AgenceBundle:Proprietaire',
                    'choice_label'  =>  'PrenomNom',
                    'multiple'      =>  false,
                    'required'      =>  false,
                    'expanded'      =>  false
                ))
                ->add('Valider', SubmitType::class, array('label' => 'valider'));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AgenceBundle\Entity\Achat'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'agencebundle_achat';
    }


}
