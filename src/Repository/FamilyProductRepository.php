<?php

namespace App\Repository;

use App\Entity\FamilyProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FamilyProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilyProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilyProduct[]    findAll()
 * @method FamilyProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilyProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FamilyProduct::class);
    }

    // /**
    //  * @return FamilyProduct[] Returns an array of FamilyProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FamilyProduct
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
