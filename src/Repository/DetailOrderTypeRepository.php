<?php

namespace App\Repository;

use App\Entity\DetailOrderType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DetailOrderType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailOrderType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailOrderType[]    findAll()
 * @method DetailOrderType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailOrderTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DetailOrderType::class);
    }

    // /**
    //  * @return DetailOrderType[] Returns an array of DetailOrderType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailOrderType
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
