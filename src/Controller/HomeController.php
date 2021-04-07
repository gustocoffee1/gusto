<?php

namespace App\Controller;

use App\Entity\PrivateSpace;
use App\Repository\BookingPrivateRepository;
use App\Repository\PrivateSpaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/space_public", name="space_public")
     */
    public function spacePublic() {
        return $this->render('home/public.html.twig');
    }

    /**
     * @Route("/space_private", name="space_private")
     */
    public function spacePrivate(PrivateSpaceRepository $repo) {

        $spaces = $repo->findAll();
        return $this->render('home/private.html.twig',[
            'spaces' => $spaces
        ]);
    }


    /**
     * @Route("/cgv", name="cgv")
     */
    public function cgv() {
        return $this->render('home/cgv.html.twig');
    }


    /**
     * @Route("/personal_data", name="personal_data")
     */
    public function personal_data() {
        return $this->render('home/personal_data.html.twig');
    }

}
