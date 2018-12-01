<?php

namespace App\Repository;

use App\Entity\SalesItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SalesItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesItems[]    findAll()
 * @method SalesItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesItemsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SalesItems::class);
    }

    // /**
    //  * @return SalesItems[] Returns an array of SalesItems objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SalesItems
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
