<?php
// Form/BienRechercheType.php
namespace AgenceBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BienRechercheType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('motcle', TextType::class, array('label'=>'motcle', 'required'=>false));
    }

    public function getName() {
        return 'bien_recherche';
    }
}