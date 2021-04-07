<?php

namespace App\Controller;

use App\Form\AccountType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager,
    UserPasswordEncoderInterface $encoder){
        $user = new User();
        $user->setCreateAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $user->setUpdateAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success',
                "Votre compte a bien été crée ! Vous pouvez à présent vous connecter");

            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(){
        return $this->render('security/login.html.twig');
    }


    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){

    }

    /**
     * Permet d'afficher et modifier le profil
     *
     * @Route("/security/profile", name="account_profile")
     *
     * @return Response
     */
    public function profile(Request $request, ObjectManager $manager){
        $user = $this->getUser();
        $user->setUpdateAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données ont bien été modifiées"
            );
        }

        return $this->render('security/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Permet d'afficher la liste des réservations
     *
     * @Route("/security/bookings", name="all_bookings")
     *
     * @return Response
     */
    public function myBookings(){

        return $this->render('security/bookings.html.twig');
    }


    /**
     * @Route("/security/delete", name="account_delete")
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete_account(ObjectManager $manager){

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $this->container->get('security.token_storage')->setToken(null);

        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "Votre compte a bien été supprimé !"
        );
        return $this->redirectToRoute("security_login");
    }


}
