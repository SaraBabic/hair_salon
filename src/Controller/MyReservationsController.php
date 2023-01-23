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
        $reservationsRepository = $doctrine->getRepository(Reservation::class)->findBy(['customer' => $user] );
        $salons = $doctrine->getRepository(Salon::class);
        $hairdresserDetails = $doctrine->getRepository(HairdresserDetails::class);
        $reservationServices = $doctrine->getRepository(ReservationServices::class);
        $servicesRepository = $doctrine->getRepository(SalonServices::class);
        $reservations = [];
        /** @var Reservation $reservation */
        $i = 0;
        $one_reservation = [];
        foreach ($reservationsRepository as $reservation) {
            // salon, address, hairdresser, time, services
            $reservationHairdresser = $reservation->getHairdresser();
            /** @var HairdresserDetails $hairdresser */


//            $startAt = $reservation->getStartAt();
//            $endAt = $reservation->getEndAt();
//            $services = $reservation->getReservationServices();
//            $one_reservation[$i]['startAt'] = $startAt;
//            $one_reservation[$i]['endAt'] = $endAt;
//            $one_reservation[$i]['reservationServices'] = $reservationServices;
//            $i++;
        }
        $reservations = $one_reservation;
//        dd($reservations);
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'salons' => $salons,
            'reservations' => $reservations,
            'hairdressers' => $hairdresserDetails
        ]);
    }
}