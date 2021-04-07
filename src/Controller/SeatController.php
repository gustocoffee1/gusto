<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SeatController extends AbstractController
{
    /**
     * @Route("/seat", name="seat")
     */
    public function index()
    {
        return $this->render('seat/index.html.twig', [
            'controller_name' => 'SeatController',
        ]);
    }
}
