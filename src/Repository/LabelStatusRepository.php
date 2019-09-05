<?php

namespace App\Repository;

use App\Entity\LabelStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LabelStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method LabelStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method LabelStatus[]    findAll()
 * @method LabelStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LabelStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LabelStatus::class);
    }

    // /**
    //  * @return LabelStatus[] Returns an array of LabelStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LabelStatus
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
