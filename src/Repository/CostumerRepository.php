<?php

namespace App\Repository;

use App\Entity\Costumer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Costumer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Costumer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Costumer[]    findAll()
 * @method Costumer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CostumerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Costumer::class);
    }

    // /**
    //  * @return Costumer[] Returns an array of Costumer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Costumer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
