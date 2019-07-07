<?php

namespace App\Repository;

use App\Entity\StorageHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StorageHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method StorageHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method StorageHistory[]    findAll()
 * @method StorageHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StorageHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StorageHistory::class);
    }

    // /**
    //  * @return StorageHistory[] Returns an array of StorageHistory objects
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
    public function findOneBySomeField($value): ?StorageHistory
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
