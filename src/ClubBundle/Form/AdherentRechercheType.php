<?php
// Form/AdherentRechercheType.php
namespace ClubBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdherentRechercheType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('motcle', TextType::class, array('label'=>'motcle', 'required'=>false));
    }

    public function getName() {
        return 'adherent_recherche';
    }
}