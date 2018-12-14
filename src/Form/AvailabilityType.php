<?php

namespace App\Form;


use App\Entity\Availability;
use App\Repository\BranchRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvailabilityType extends AbstractType
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
            ->add('workdate')
            ->add('hours')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Availability::class,
        ]);
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
