<?php

namespace App\Repository;

use App\Entity\BookingService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BookingService|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingService|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingService[]    findAll()
 * @method BookingService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingService::class);
    }

    // /**
    //  * @return BookingService[] Returns an array of BookingService objects
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
    public function findOneBySomeField($value): ?BookingService
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
