<?php

namespace App\Repository;

use App\Entity\BookingServicePrivate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BookingServicePrivate|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingServicePrivate|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingServicePrivate[]    findAll()
 * @method BookingServicePrivate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingServicePrivateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingServicePrivate::class);
    }

    // /**
    //  * @return BookingServicePrivate[] Returns an array of BookingServicePrivate objects
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
    public function findOneBySomeField($value): ?BookingServicePrivate
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
