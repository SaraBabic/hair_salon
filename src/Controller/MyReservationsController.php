<?php

namespace App\Controller;

use App\Entity\HairdresserDetails;
use App\Entity\Reservation;
use App\Entity\ReservationServices;
use App\Entity\Salon;
use App\Entity\SalonServices;
use App\Entity\User;
use App\Form\HairdresserCreateForm;
use App\Form\SalonForm;
use App\Form\ServiceCreateForm;
use App\Form\WorkingHoursForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\SalonWorkingHours;

class MyReservationsController extends AbstractController
{
    //my reservations
    #[Route('/user/{id}/reservations', name: 'app_user_reservations')]
    public function index(ManagerRegistry $doctrine, $id): Response
    {
        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        $reservations = $doctrine->getRepository(Reservation::class)->findBy(['customer' => $user] );
        $salons = $doctrine->getRepository(Salon::class);
        $hairdresserDetails = $doctrine->getRepository(HairdresserDetails::class);
        $reservationServices = $doctrine->getRepository(ReservationServices::class);
        $servicesRepository = $doctrine->getRepository(SalonServices::class);
        /** @var Reservation $reservation */



        return $this->render('user/index.html.twig', [
            'user' => $user,
            'salons' => $salons,
            'reservations' => $reservations,
            'hairdressers' => $hairdresserDetails
        ]);
    }

    // Activate/Deactivate hairdresser
    #[Route('/user/{id}/reservation/{reservation_id}/cancel', name: 'cancel_reservation', methods: ['GET'])]
    public function cancel_reservation($reservation_id, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, $id): Response
    {
        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        $reservationRepository = $doctrine->getRepository(Reservation::class);
        /** @var Reservation $reservation */
        $reservation = $reservationRepository->find($reservation_id);

        if($reservation->getCanceled()) {
            $reservation->setCanceled(false);
        }
        else {
            $reservation->setCanceled(true);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_user_reservations', [
            'user' => $user,
            'id' => $id,
        ]);
    }
}