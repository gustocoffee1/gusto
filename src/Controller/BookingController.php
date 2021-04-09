<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\BookingPrivate;
use App\Entity\BookingSeat;
use App\Entity\PrivateSpace;
use App\Entity\BookingService;
use App\Entity\Service;
use App\Entity\BookingPrivateService;
use App\Entity\User;
use App\Entity\Seat;
use App\Form\BookingType;
use App\Repository\BookingPrivateRepository;
use App\Repository\BookingRepository;
use App\Repository\PrivateSpaceRepository;
use App\Repository\ServiceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use MongoDB\Driver\Manager;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking", methods={"GET","POST"})
     */
    public function book(BookingRepository $bookingRepository)
    {
        return $this->render('booking/book.html.twig', [
//            'seat' => $seat,
            'user' => $this->getUser(),
            'bookings' => $bookingRepository->findAllDate(),

        ]);
    }

    /**
     * @Route("/booking/seat", name="booking_seat", methods={"GET","POST"})
     */
    public function seat(Request $request, BookingRepository $bookingRepository){
        $session = $this->get('session');

        $start_date = $session->get('startDate');
        $end_date = $session->get('endDate');

        $start_date = \DateTime::createFromFormat('d/m/Y H:i', $start_date);
        $start_date = $start_date->format('Y-m-d H:i');

        $end_date = \DateTime::createFromFormat('d/m/Y H:i', $end_date);
        $end_date = $end_date->format('Y-m-d H:i');

//        dump($start_date);
        return $this->render('booking/seat.html.twig', [
//            'data' => $session,
            'seats' => $bookingRepository->findAllSeat($start_date, $end_date),
        ]);

    }

    /**
     * @Route("/booking/services", name="services_form", methods={"GET","POST"})
     */
    public function service(Request $request, ServiceRepository $repo){
        $session = $request->getSession();


        $pricetotal = $request->get('pricetotal');
        $session->set('price', $pricetotal);
        $seats = $request->get('input');

        $session->set('seats_id', $seats);

        $formules = $repo->findAllFormule();
        $supports = $repo->findAllSupport();
        return $this->render('booking/services.html.twig',[
            'formules' => $formules,
            'supports' => $supports
        ]);
    }


    /**
     * @Route("/booking/", name="reservation_form", methods={"GET","POST"})
     * @param Booking $booking
     * @return Response
     */
    public function reservationForm(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $startDate = $request->get('startDate');
            $endDate = $request->get('endDate');
            $email = $request->get('email');
            $firstname = $request->get('firstname');
            $lastname = $request->get('lastname');
            $phone = $request->get('phone');
            $society = $request->get('society');
            $price = $request->get('price');

            $session = $request->getSession();
            $session->set('startDate', $startDate);
            $session->set('endDate', $endDate);
            $session->set('email', $email);
            $session->set('firstname', $firstname);
            $session->set('lastname', $lastname);
            $session->set('phone', $phone);
            $session->set('society', $society);
            $session->set('price', $price);
//            $request->request->get('request');

            $response = [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'email' => $email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'society' => $society,
                'price' => $price,
            ];


        }

        return $this->json($response);
    }


    /**
     * @Route("/booking/payment", name="payment", methods={"GET","POST"})
     */
    public function myPayment(Request $request, ObjectManager $manager){

            $price = $request->getSession()->get('price');

            $total = $request->getSession()->get('total');

            $price_total = $price + $total;


            $price_total = str_replace(",", ".", $price_total);
//            converti de centime en euro pour stripe
            $price_stripe = $price_total * 100;

            \Stripe\Stripe::setApiKey('sk_test_2OATFWdlNgcnC6e0KqXBQpGc00gIQS9KvA');

            \Stripe\PaymentIntent::create([

                'amount' => $price_stripe ,
                'currency' => 'eur',
                'payment_method' => 'pm_card_visa',
                'confirm' => true,
                'source' => $request->get('stripeToken'),
                // Verify your integration in this guide by including this parameter
                'metadata' => ['integration_check' => 'accept_a_payment'],
            ]);


            $startDate = $request->getSession()->get('startDate');
            $startDate = \DateTime::createFromFormat('d/m/Y H:i', $startDate);
            $startDate = $startDate->format('Y-m-d H:i');

            $endDate = $request->getSession()->get('endDate');
            $endDate = \DateTime::createFromFormat('d/m/Y H:i', $endDate);
            $endDate = $endDate->format('Y-m-d H:i');
            $booker = $this->getUser();

            $email = $request->getSession()->get('email');
            $firstname = $request->getSession()->get('firstname');
            $lastname = $request->getSession()->get('lastname');
            $society = $request->getSession()->get('society');
            $phone = $request->getSession()->get('phone');

//        Inserer les informations en base de donnnée lorsque le paiement est ok
            $booking = new Booking();
            $booking->setBooker($booker);
            $booking->setStartDate(new \DateTime($startDate));
            $booking->setEndDate(new \DateTime($endDate));
            $booking->setCreatedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $booking->setActive(true);
            $booking->setAmount($price_total);
            $booking->setEmail($email);
            $booking->setFirstname($firstname);
            $booking->setLastname($lastname);
            $booking->setSociety($society);
            $booking->setPhone($phone);

            $manager->persist($booking);
            $manager->flush();


         $em = $this->getDoctrine()->getManager();

        //recupere dernier id reservation et converti en objet
         $id_booking = $em->getRepository(Booking::class)->findOneBy(array('id' => ($booking->getId())));

         $seats_id = $request->getSession()->get('seats_id');

        // inserer places dans la 2eme table
            foreach($seats_id as $key => $value) {
                $seat_id = $em->getRepository(Seat::class)->findOneBy(array('id' => ($value)));
                $booking_seat = new BookingSeat();
                $booking_seat->setBooking($id_booking);
                $booking_seat->setSeat($seat_id);
                //persist = insert into
                $manager->persist($booking_seat);
            }
            $manager->flush();

        //inserer les services dans la table
        $qty_items = $request->getSession()->get('qty_item');
        $price_items = $request->getSession()->get('price_item');


        foreach($qty_items as $key_qty => $value_qty) {
            $price_item = $price_items[$key_qty];

            $key_qty++;
            $booking_service = new BookingService();
            $booking_service->setQuantity($value_qty);

            $service_id = $em->getRepository(Service::class)->findOneBy(array('id' => ($key_qty)));

            $booking_service->setBookingService($id_booking);
            $booking_service->setService($service_id);
            $booking_service->setPrice($price_item);

            $manager->persist($booking_service);

        }
        $manager->flush();


        return $this->render('booking/payment.html.twig');
    }

    /**
     * @Route("/booking/stripe_payment", name="payment_stripe", methods={"GET","POST"})
     */
    public function formPayment(Request $request){

        if ($request->isMethod('POST')) {

            //quantité de chaque produit
            $qty = $request->request->get('qty');

            //prix de chaque produit
            $price = $request->request->get('price');

            //total
            $total = $request->request->get('total-item');

            $session = $request->getSession();

            $session->set('qty_item', $qty);
            $session->set('price_item', $price);
            $session->set('total', $total);


        }
        return $this->render('booking/payment.html.twig');
    }

    /**
     * @Route("/booking_private/", name="reservation_form_private", methods={"GET","POST"})
     * @param BookingPrivate $booking
     * @return Response
     */
    public function reservationFormPrivate(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $startDate = $request->get('startDate');
            $endDate = $request->get('endDate');
            $email = $request->get('email');
            $firstname = $request->get('firstname');
            $lastname = $request->get('lastname');
            $phone = $request->get('phone');
            $society = $request->get('society');
            $price = $request->get('price');
            $space_id = $request->get('space_id');


            $session = $request->getSession();
            $session->set('startDate', $startDate);
            $session->set('endDate', $endDate);
            $session->set('email', $email);
            $session->set('firstname', $firstname);
            $session->set('lastname', $lastname);
            $session->set('phone', $phone);
            $session->set('society', $society);
            $session->set('price', $price);
            $session->set('space_id', $space_id);

            $response = [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'email' => $email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'society' => $society,
                'price' => $price,
                'space_id' => $space_id,
            ];
        }

        return $this->json($response);
    }

    /**
     * @Route("/booking_private/services", name="services_form_private", methods={"GET","POST"})
     */
    public function servicePrivate(Request $request, ServiceRepository $repo){


        $formules = $repo->findAllFormule();
        $supports = $repo->findAllSupport();
        return $this->render('booking/services_private.html.twig',[
            'formules' => $formules,
            'supports' => $supports
        ]);
    }

    /**
     * @Route("/booking/payment_private", name="payment_private", methods={"GET","POST"})
     */
    public function myPaymentPrivate(Request $request, ObjectManager $manager){

        $price = $request->getSession()->get('price');

        $total = $request->getSession()->get('total');

        $price_total = $price + $total;

        $price_total = str_replace(",", ".", $price_total);
//            converti de centime en euro pour stripe
        $price_stripe = $price_total * 100;


        \Stripe\Stripe::setApiKey('sk_test_2OATFWdlNgcnC6e0KqXBQpGc00gIQS9KvA');

        \Stripe\PaymentIntent::create([

            'amount' => $price_stripe ,
            'currency' => 'eur',
            'payment_method' => 'pm_card_visa',
            'confirm' => true,
            'source' => $request->get('stripeToken'),
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);


        $startDate = $request->getSession()->get('startDate');
        $startDate = \DateTime::createFromFormat('d/m/Y H:i', $startDate);
        $startDate = $startDate->format('Y-m-d H:i');

        $endDate = $request->getSession()->get('endDate');
        $endDate = \DateTime::createFromFormat('d/m/Y H:i', $endDate);
        $endDate = $endDate->format('Y-m-d H:i');
        $booker = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $space_id = $em->getRepository(PrivateSpace::class)->findOneBy(array('id' => ($request->getSession()->get('space_id'))));


        $email = $request->getSession()->get('email');
        $firstname = $request->getSession()->get('firstname');
        $lastname = $request->getSession()->get('lastname');
        $society = $request->getSession()->get('society');
        $phone = $request->getSession()->get('phone');

//        Inserer les informations en base de donnnée lorsque le paiement est ok
        $booking = new BookingPrivate();
        $booking->setRelation($booker);
        $booking->setStartDate(new \DateTime($startDate));
        $booking->setEndDate(new \DateTime($endDate));
        $booking->setCreatedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $booking->setActive(true);
        $booking->setAmount($price_total);

        $booking->setSpace($space_id);

        $booking->setEmail($email);
        $booking->setFirstname($firstname);
        $booking->setLastname($lastname);
        $booking->setSociety($society);
        $booking->setPhone($phone);

        $manager->persist($booking);
        $manager->flush();


        //inserer les services dans la table
        $qty_items = $request->getSession()->get('qty_item');
        $price_items = $request->getSession()->get('price_item');

        //recupere dernier id reservation et converti en objet
        $id_booking = $em->getRepository(BookingPrivate::class)->findOneBy(array('id' => ($booking->getId())));

        foreach($qty_items as $key_qty => $value_qty) {
            $price_item = $price_items[$key_qty];

            $key_qty++;
            $booking_private_service = new BookingPrivateService();
            $booking_private_service->setQuantity($value_qty);

            $service_id = $em->getRepository(Service::class)->findOneBy(array('id' => ($key_qty)));

            $booking_private_service->setBookingPrivateService($id_booking);
            $booking_private_service->setPrivateService($service_id);
            $booking_private_service->setPrice($price_item);

            $manager->persist($booking_private_service);

        }
        $manager->flush();

        return $this->render('booking/payment_private.html.twig');
    }


    /**
     * @Route("/booking/stripe_payment_private", name="payment_stripe_private")
     */
    public function formPaymentPrivate(Request $request){
        if ($request->isMethod('POST')) {
            //quantité de chaque produit
            $qty = $request->request->get('qty');

            //prix de chaque produit
            $price = $request->request->get('price');

            //total
            $total = $request->request->get('total-item');

            $session = $request->getSession();

            $session->set('qty_item', $qty);
            $session->set('price_item', $price);
            $session->set('total', $total);

        }
        return $this->render('booking/payment_private.html.twig');
    }

    /**
     * @Route("/booking_show/{id}", name="booking_show")
     * @param Booking $booking
     * @return Response
     */
    public function show($id, Booking $booking, BookingRepository $repobook){
        $public = $repobook->findAllForPublic($id);
        $public_seat = $repobook->findAllSeatsPublic($id);
        $services = $repobook->findAllServices($id);
        return $this->render('booking/show.html.twig', [
            'booking' => $public,
            'seats' => $public_seat,
            'services' => $services
        ]);
    }

    /**
     * @Route("/booking_private_show/{id}", name="booking_private_show")
     * @param BookingPrivate $booking
     * @return Response
     */
    public function showPrivate($id, BookingPrivate $booking, BookingPrivateRepository $repobook){

        $private = $repobook->findAllForPrivate($id);
        $services = $repobook->findAllServicesPrivate($id);
        return $this->render('booking/show_private.html.twig', [
            'booking' => $private,
            'services' => $services
        ]);
    }

    /**
     * @Route("/bookings/{id}/delete", name="booking_delete")
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Booking $booking, ObjectManager $manager){

        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            "La réservation a bien été supprimée !"
        );
        return $this->redirectToRoute("all_bookings");
    }

    /**
     * @Route("/bookings_private/{id}/delete", name="booking_private_delete")
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete_private(BookingPrivate $booking, ObjectManager $manager){

        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            "La réservation a bien été supprimée !"
        );
        return $this->redirectToRoute("all_bookings");
    }




    /**
     * @Route("/booking_private/{id}", name="booking_private", methods={"GET","POST"})
     */
    public function bookPrivate($id, PrivateSpaceRepository $repo, BookingPrivateRepository $repobook)
    {
        $private = $repo->findOneById($id);
        $bookings = $repobook->findAllDate($id);
//        dump($bookings);
        return $this->render('booking/book_private.html.twig', [

            'user' => $this->getUser(),
            'private' => $private,
            'bookings' => $bookings,

        ]);
    }
}
