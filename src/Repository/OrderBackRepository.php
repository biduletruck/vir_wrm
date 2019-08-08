<?php

namespace App\Repository;

use App\Entity\OrderBack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OrderBack|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderBack|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderBack[]    findAll()
 * @method OrderBack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderBackRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OrderBack::class);
    }

    // /**
    //  * @return OrderBack[] Returns an array of OrderBack objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderBack
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
