<?php

namespace App\Repository;

use App\Entity\BookingPrivateService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BookingPrivateService|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingPrivateService|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingPrivateService[]    findAll()
 * @method BookingPrivateService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingPrivateServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingPrivateService::class);
    }

    // /**
    //  * @return BookingPrivateService[] Returns an array of BookingPrivateService objects
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
    public function findOneBySomeField($value): ?BookingPrivateService
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
