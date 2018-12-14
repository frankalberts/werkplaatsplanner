<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 5-12-2018
 * Time: 10:51
 */

namespace App\Repository;

use App\Entity\Availability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CalenderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Availability::class);
    }

    /**
     * @param $filiaal
     * @return Availability[]
     */
    public function findByFiliaal($filiaal)
    {
        return $this->createQueryBuilder('a')
            ->where('a.branch = :val')
            ->setParameter('val', $filiaal)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(31)
            ->getQuery()
            ->getResult()
        ;
    }
}