<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 5-12-2018
 * Time: 11:05
 */

namespace App\Form;


use App\Repository\BranchRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class CalenderType extends AbstractType
{
    /** @var BranchRepository */
    private $branchRepository;

    /**
     * @param BranchRepository $branchRepository
     */
    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Branch', ChoiceType::class, array(
                'label' => 'Filiaal',
                'data' => 'Autobedrijf Vechtdal Hardenberg',
                'choices' => $this->getBranches(),
                ));
    }

    private function getBranches() : array
    {
        $branches = $this->branchRepository->findAll();
        $result = [];
        foreach ($branches as $branch) {
            $result[$branch['name']] = $branch['city'];
        }
        return $result;
    }
}