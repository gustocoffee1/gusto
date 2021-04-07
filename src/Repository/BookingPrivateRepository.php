<?php

namespace App\Repository;

use App\Entity\BookingPrivate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BookingPrivate|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingPrivate|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingPrivate[]    findAll()
 * @method BookingPrivate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingPrivateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingPrivate::class);
    }

    public function findAllDate($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT start_date, end_date FROM booking_private WHERE space_id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();

    }

    public function findAllForPrivate($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT b.id, b.lastname, b.email, b.phone, b.start_date, b.end_date, b.amount, p.name, p.quantity FROM booking_private b 
        INNER JOIN private_space p ON b.space_id = p.id 
        WHERE b.id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();

    }

    // /**
    //  * @return BookingPrivate[] Returns an array of BookingPrivate objects
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
    public function findOneBySomeField($value): ?BookingPrivate
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
