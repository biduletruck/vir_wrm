<?php

namespace App\Repository;

use App\Entity\Storages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Storages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Storages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Storages[]    findAll()
 * @method Storages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoragesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Storages::class);
    }




    // /**
    //  * @return Storages[] Returns an array of Storages objects
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
    public function findOneBySomeField($value): ?Storages
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
