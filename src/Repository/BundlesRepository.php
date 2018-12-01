<?php

namespace App\Repository;

use App\Entity\Bundles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bundles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bundles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bundles[]    findAll()
 * @method Bundles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BundlesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bundles::class);
    }

    // /**
    //  * @return Bundles[] Returns an array of Bundles objects
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
    public function findOneBySomeField($value): ?Bundles
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
