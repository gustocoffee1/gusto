<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function findAllDate()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT start_date, end_date, bs.seat_id
        FROM booking b
        INNER JOIN booking_seat bs ON b.id = bs.booking_id ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
//        var_dump($stmt->fetchAll());die;
    }

    public function findAllSeat($start, $end)
    {
        $conn = $this->getEntityManager()->getConnection();
//        $sql = "SELECT start_date, end_date, seat_id FROM booking WHERE start_date BETWEEN '$start' AND '$end'
//        AND end_date BETWEEN '$start' AND '$end' ";

        $sql = "SELECT start_date, end_date, bs.seat_id 
        FROM booking b
        INNER JOIN booking_seat bs ON b.id = bs.booking_id 
        WHERE start_date <= '$end' AND end_date > '$start' 
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();


    }

    public function findAllForPublic($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT b.id, b.lastname, b.email, b.phone, b.start_date, b.end_date, b.amount 
        FROM booking b
        WHERE b.id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();

    }

    public function findAllSeatsPublic($id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT s.name
        FROM seat s
        INNER JOIN booking_seat bs ON bs.seat_id = s.id 
        WHERE bs.booking_id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findAllServices($id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT s.title, bs.quantity, bs.price
        FROM booking_service bs
        INNER JOIN service s ON s.id = bs.service_id 
        WHERE bs.quantity > '0' AND bs.booking_service_id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }





    // /**
    //  * @return Booking[] Returns an array of Booking objects
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
    public function findOneBySomeField($value): ?Booking
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
