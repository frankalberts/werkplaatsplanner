<?php

namespace App\Form;

use App\Entity\Maintenance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaintenanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => 'Titel'))
            ->add('description', null, array('label' => 'Omschrijving'))
            ->add('duration', ChoiceType::class, array(
                'choices' => array(
                    '1 uur' => 1,
                    '2 uur' => 2,
                    '4 uur' => 4,
                    '8 uur' => 8,
                ),
                'label' => 'Duur'
            ))
            ->add('price', MoneyType::class, array(
                'divisor' => 100,
                'label' => 'Prijs',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Maintenance::class,
        ]);
    }
}
