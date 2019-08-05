<?php

namespace App\Repository;

use App\Entity\Locations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Locations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Locations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Locations[]    findAll()
 * @method Locations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Locations::class);
    }

    public function occupancyRateWarehouse($agency)
    {
        return $this->createQueryBuilder('l')
            ->select('count(l.id) as total, sum(l.FreePlace) as libre')
            ->andWhere('l.Agency = :val')
            ->setParameter('val', $agency)
            ->getQuery()
            ->getResult()
            ;
    }

public function occupancyByDriveWay($agency)
    {
        return $this->createQueryBuilder('l')
            ->select('l.driveway, count(l.id) as total, sum(l.FreePlace) as libre')
            ->andWhere('l.Agency = :val')
            ->setParameter('val', $agency)
            ->groupBy('l.driveway')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByAgency($agency)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.Agency = :val')
            ->setParameter('val', $agency)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Locations[] Returns an array of Locations objects
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
    public function findOneBySomeField($value): ?Locations
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
