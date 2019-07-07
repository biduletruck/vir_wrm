<?php

namespace App\Repository;

use App\Entity\StatusOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StatusOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusOrder[]    findAll()
 * @method StatusOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusOrderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StatusOrder::class);
    }

    // /**
    //  * @return StatusOrder[] Returns an array of StatusOrder objects
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
    public function findOneBySomeField($value): ?StatusOrder
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
