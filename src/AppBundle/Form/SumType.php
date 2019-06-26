<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SumType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    /*
    for ($i=0; $i<$options['operands']; $i++) {
      $builder->add('op' . $i, NumberType::class);
    }
    */

    $builder->add('operands', CollectionType::class, [
      'entry_type' => NumberType::class
    ]);

    $builder->add('result', NumberType::class);
  }

//  public function configureOptions(OptionsResolver $resolver) {
//    $resolver->setDefaults([
//      'operands' => 2,
//    ]);
//  }
}