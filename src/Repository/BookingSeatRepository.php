<?php

namespace App\Repository;

use App\Entity\BookingSeat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BookingSeat|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingSeat|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingSeat[]    findAll()
 * @method BookingSeat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingSeatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingSeat::class);
    }

    // /**
    //  * @return BookingSeat[] Returns an array of BookingSeat objects
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
    public function findOneBySomeField($value): ?BookingSeat
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
