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


class BienType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('nomBien')
                ->add('dateConstruction', DateType::class, array('years' => range(date('Y')-120, date('Y')+0)))
                ->add('prix')
                ->add('visiteurs', EntityType::class, array(
                    'class'         =>  'AgenceBundle:Visiteur',
                    'choice_label'  =>  'PrenomNom',
                    'multiple'      =>  true,
                    'required'      =>  false,
                    'expanded'      =>  false
                ))
                ->add('types', EntityType::class, array(
                    'class'         =>  'AgenceBundle:TypeBien',
                    'choice_label'  =>  'nomType',
                    'multiple'      =>  false,
                    'required'      =>  true
                ))
                ->add('Valider', SubmitType::class, array('label' => 'valider'));
    }  
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AgenceBundle\Entity\Bien'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'agencebundle_bien';
    }
}
