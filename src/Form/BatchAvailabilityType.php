<?php

namespace App\Form;

use App\Entity\Availability;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BatchAvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('branch')
            ->add('fromdate', DateType::class)
            ->add('todate', DateType::class)
            ->add('days', CheckboxType::class, array(
                'choices' => array(
                    'Maandag' => 0,
                    'Dinsdag' => 1,
                    'Woensdag' => 2,
                    'Donderdag' => 3,
                    'Vrijdag' => 4,
                    'Zaterdag' => 5,
                    'Zondag' => 6
            )))
            ->add('hours')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Availability::class,
        ]);
    }
}
