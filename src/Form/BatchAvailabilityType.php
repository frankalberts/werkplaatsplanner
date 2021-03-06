<?php

namespace App\Form;

use App\Entity\Availability;
use App\Repository\BranchRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BatchAvailabilityType extends AbstractType
{
    /** @var BranchRepository */
    private $branchRepository;

    /**
     * AvailabilityType constructor.
     * @param BranchRepository $branchRepository
     */

    public function __construct(BranchRepository $branchRepository){
        $this->branchRepository = $branchRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('branch', ChoiceType::class, array('label' => 'Filiaal', 'choices' => $this->getBranches(),))
            ->add('fromdate', DateType::class, array('widget' => 'choice', 'data' => new \DateTime()))
            ->add('todate', DateType::class, array('widget' => 'choice', 'data' => new \DateTime()))
            ->add('days', ChoiceType::class, array(
                'choices' => array(
                    'Maandag' => 0,
                    'Dinsdag' => 1,
                    'Woensdag' => 2,
                    'Donderdag' => 3,
                    'Vrijdag' => 4,
                    'Zaterdag' => 5,
                    'Zondag' => 6
                ),
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'label' => "Welke dagen word het onderhoud uitgevoerd."
                ))
            ->add('hours', null, array('label' => 'Uren'))
        ;
    }

    private function getBranches(): array
    {
        $branches = $this->branchRepository->findall();
        $result = [];
        foreach ($branches as $branch) {
            $result[$branch['name']] = $branch['city'];
        }

        return $result;
    }
}
