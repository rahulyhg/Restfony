<?php

namespace App\Repository;

use App\Entity\BundleElements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BundleElements|null find($id, $lockMode = null, $lockVersion = null)
 * @method BundleElements|null findOneBy(array $criteria, array $orderBy = null)
 * @method BundleElements[]    findAll()
 * @method BundleElements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BundleElementsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BundleElements::class);
    }

    // /**
    //  * @return BundleElements[] Returns an array of BundleElements objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BundleElements
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
