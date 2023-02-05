<?php

namespace App\Controller;

use App\Entity\HairdresserDetails;
use App\Entity\Reservation;
use App\Entity\ReservationServices;
use App\Entity\Salon;
use App\Entity\SalonRating;
use App\Entity\SalonServices;
use App\Entity\User;
use App\Form\HairdresserCreateForm;
use App\Form\SalonForm;
use App\Form\ServiceCreateForm;
use App\Form\WorkingHoursForm;
use App\Repository\SalonRepository;
use App\Repository\UserRepository;
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
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
        $reservations = $doctrine->getRepository(Reservation::class)->findBy(['customer' => $user] );
        $salons = $doctrine->getRepository(Salon::class);
        $hairdresserDetails = $doctrine->getRepository(HairdresserDetails::class);
        $reservationServices = $doctrine->getRepository(ReservationServices::class);
        $servicesRepository = $doctrine->getRepository(SalonServices::class);
        $ratings  = $doctrine->getRepository(SalonRating::class)->findBy(['user'=>$user]);
        /** @var Reservation $reservation */



        return $this->render('user/index.html.twig', [
            'user' => $user,
            'salons' => $salons,
            'reservations' => $reservations,
            'hairdressers' => $hairdresserDetails,
            'ratings' => $ratings
        ]);
    }

    // Activate/Deactivate hairdresser
    #[Route('/user/{id}/reservation/{reservation_id}/cancel', name: 'cancel_reservation', methods: ['GET'])]
    public function cancel_reservation($reservation_id, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, $id): Response
    {
        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
        $reservationRepository = $doctrine->getRepository(Reservation::class);
        /** @var Reservation $reservation */
        $reservation = $reservationRepository->find($reservation_id);
        if(!$reservation){
            return $this->redirectToRoute('app_home');
        }
        if(!$reservation->getCanceled()) {
            $reservation->setCanceled(true);
        }

        $entityManager->flush();

        if(in_array('ROLE_HAIRDRESSER',$user->getRoles(), true)){
            return $this->redirectToRoute('app_hairdresser_dashboard',['id'=>$user->getId()]);
        }
        if(in_array('ROLE_OWNER',$user->getRoles(), true)){
            return $this->redirectToRoute('app_reservations', ['id'=>$user->getId(), 'salon_id'=> $user->getSalon()->getId()]);
        }
        return $this->redirectToRoute('app_user_reservations', [
            'user' => $user,
            'id' => $id,
        ]);
    }

    #[Route('user/{id}/salon/{salon_id}/rate', name: 'app_rate_salon')]
    public function rateSalon(int $id, int $salon_id, SalonRepository $salonRepository):Response
    {
        if(!$this->getUser()){
            $this->redirectToRoute('app_home');
        }
        $salon = $salonRepository->findOneBy(['id'=>$salon_id]);
        if(!$salon){
            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/rating.html.twig',[
            'salon'=>$salon
        ]);
    }
    #[Route('user/{id}/salon/{salon_id}/rate/save', name: 'app_save_rate_salon')]
    public function saveRateSalon(Request $request, int $id, int $salon_id, SalonRepository $salonRepository, UserRepository $userRepository, EntityManagerInterface $em):Response
    {
        $user = $userRepository->findOneBy(['id'=>$id]);
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
        $salon = $salonRepository->findOneBy(['id'=>$salon_id]);
        if(!$salon){
            return $this->redirectToRoute('app_home');
        }
        $rate = $request->get('stars');
        $rating = new SalonRating();
        $rating->setUser($user);
        $rating->setSalon($salon);
        $rating->setRate($rate[0]);
        $em->persist($rating);
        $em->flush();

        return $this->redirectToRoute('app_user_reservations', [
            'user'=>$user,
            'id'=>$id
        ]);
    }

}