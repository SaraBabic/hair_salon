<?php

namespace App\Controller;


use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HairdresserController extends AbstractController {
    //hairdressers dashboard
    #[Route('/hairdresser/{id}/dashboard', name: 'app_hairdresser_dashboard')]
    public function index(ManagerRegistry $doctrine, $id):Response {
        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        $salon = $user->getSalon();
        $reservations = $doctrine->getRepository(Reservation::class)->findBy(['hairdresser' => $user] );


        return $this->render('hairdresser/index.html.twig', [
            'salon' => $salon,
            'user' => $user,
            'reservations' => $reservations,
        ]);
    }
}