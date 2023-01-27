<?php

namespace App\Controller;

use App\Entity\HairdresserDetails;
use App\Entity\Reservation;
use App\Entity\ReservationServices;
use App\Entity\SalonServices;
use App\Entity\SalonWorkingHours;
use App\Entity\User;
use App\Form\WorkingHoursForm;
use App\Repository\SalonRatingRepository;
use App\Repository\SalonRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController {
    #[Route('/salon/{id}/reservation', name:'app_salon_reservation')]
    public function salonReservation(SalonRepository $repository, SalonRatingRepository $ratingRepository, int $id, ManagerRegistry $doctrine):Response
    {
        $salon = $repository->findOneBy(['id'=>$id]);
        $salonRating = $ratingRepository->findAverageRatingForSalon($id);

        $hairdressers = $doctrine->getRepository(HairdresserDetails::class)->findBy(['salon' => $salon->getId()]);

        return $this->render('reservation/index.html.twig',[
            'salon'=>$salon,
            'rating' => $salonRating[0],
            'hairdressers' => $hairdressers
        ]);
    }

    #[Route('/getFreeHours', name:'app_get_free_hours')]
    public function getFreeHours(Request $request, ManagerRegistry $doctrine) {
        $salonId = (int) $request->query->get('salonId');
        $totalDuration = (int) $request->query->get('totalDuration');
        $date = $request->query->get('date');
        $hairdresserId = $request->query->get('hairdresser');


        $datetime = new \DateTime($date);
        $dayOfTheWeek = $datetime->format('N');
        $workingHours = $doctrine->getRepository(SalonWorkingHours::class)->findBy(['salon' => $salonId, 'day' => $dayOfTheWeek]);
        $openingHour = new \DateTime($date . ' ' . $workingHours[0]->getOpeningAt());
        $closingHour = new \DateTime($date . ' ' . $workingHours[0]->getClosingAt());

        $res = [new \DateTime($openingHour->format('Y-m-d H:i:s'))];
        for ($i = 0; $i < 48; ++$i) {
            $openingHour->add(new \DateInterval('PT' . 30 . 'M'));
            if ($openingHour <= $closingHour) {
                $res[] = new \DateTime($openingHour->format('Y-m-d H:i:s'));
            }
        }

        $reservations = $doctrine->getRepository(Reservation::class)->findBy(['hairdresser' => $hairdresserId]);

        $tries = $totalDuration / 30;
        $r2 = [];
        $resIdx = 0;
        $shouldAdd = true;
        foreach ($res as $idx => $r) {
            for ($i = 0; $i < $tries; ++$i) {
                $currentTimeIdx = $idx + $i;
                if ($currentTimeIdx === count($res)-1) {
                    $shouldAdd = false;
                    break;
                }

                foreach ($reservations as $dbRes) {
                    if (
                        $res[$currentTimeIdx]->format('Y-m-d H:i:s') >= $dbRes->getStartAt()->format('Y-m-d H:i:s')
                        &&
                        $res[$currentTimeIdx]->format('Y-m-d H:i:s') < $dbRes->getEndAt()->format('Y-m-d H:i:s')
                    ) {
                        $shouldAdd = false;
                        break 2;
                    }
                }
                $shouldAdd = true;
            }

            if ($shouldAdd) {
                $r2[] = $r;
            }
        }


        // final formatting
        $displayRes = [];
        foreach ($r2 as $r) {
            $displayRes[] = $r->format('H:i');
        }

        return $this->json([
            'data' => $displayRes
        ]);
    }

    #[Route('/reservation', name:'app_create_reservation', methods: ["POST"])]
    public function createReservation(Request $request, \Doctrine\ORM\EntityManagerInterface $em)
    {
        $haidresserId = (int) $request->get('hairdresser');
        $servicesIds = $request->get('services');
        $dateOfReservation = $request->get('reservationDate');
        $timeOfReservation = $request->get('timeSelection') . ":00";
        $startAt =  $dateOfReservation . ' ' . $timeOfReservation;
        $totalDuration = (int) $request->get('td');

        $salon = (int)  $request->get('salon');

        $endAt = new \DateTime($startAt);
        $endAt->add(new \DateInterval('PT' . $totalDuration . 'M'));

        $hdRepo = $em->getRepository(User::class);
        $hd = $hdRepo->findOneBy(['id' => $haidresserId]);

        $ssRepo = $em->getRepository(SalonServices::class);
        $services = $ssRepo->findBy(['id' => $servicesIds]);

        $res = new Reservation();
        $res->setStartAt(new \DateTimeImmutable($startAt));
        $res->setEndAt(new \DateTimeImmutable($endAt->format('Y-m-d H:i:s')));
        $res->setHairdresser($hd);
        $res->setCustomer($this->getUser());
        $res->setSalon($salon);
        $em->persist($res);
        $em->flush();

        foreach ($services as $s) {
            $rs = new ReservationServices();
            $rs->setReservation($res);
            $rs->setService($s);
            $em->persist($rs);
        }
        $em->flush();

        return $this->redirectToRoute('app_home');
    }
}