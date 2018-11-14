<?php

namespace App\Form;

use App\Entity\Costumer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CostumerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array('label' => 'Voornaam'))
            ->add('lastname', null, array('label' => 'Achternaam'))
            ->add('prefix')
            ->add('street', null, array('label' => 'Straat'))
            ->add('housenumber', NumberType::class, array('label' => 'Huisnummer'))
            ->add('postalcode', null, array('label' => 'Postcode'))
            ->add('city', null, array('label' => 'Plaats'))
            ->add('phone', null, array('label' => 'Telefoonnummer'))
            ->add('email')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Costumer::class,
        ]);
    }
}
