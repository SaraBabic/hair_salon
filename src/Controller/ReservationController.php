<?php

namespace App\Controller;

use App\Entity\HairdresserDetails;
use App\Entity\SalonWorkingHours;
use App\Form\WorkingHoursForm;
use App\Repository\SalonRatingRepository;
use App\Repository\SalonRepository;
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
        $salonId = $request->query->get('salonId');
        $totalDuration = (int) $request->query->get('totalDuration');
        $date = $request->query->get('date');


        $datetime = new \DateTime($date);
        $dayOfTheWeek = $datetime->format('N');
        $workingHours = $doctrine->getRepository(SalonWorkingHours::class)->findBy(['salon' => $salonId, 'day' => $dayOfTheWeek]);

        $closing = rtrim($workingHours[0]->getClosingAt(), "0");
        $closing = rtrim($closing, ":");
        $closingHours = substr($closing,0,2);
        $hours = 0;
        $mins = 0;
        $maxHours = substr($closing,0,2);
        $maxMins = substr($closing,3,2);
        if($totalDuration > 60) {
            $mins = $totalDuration % 60;
            $hours = round($totalDuration/60);
        }
        if(strlen($closing) < 3 && $closingHours[0] == 0) {
            $maxHours = $closingHours[1] - $hours;
        }
        elseif(strlen($closing) < 3) {
            $maxHours = $closingHours - $hours;
        }
        elseif(strlen($closing) > 3 && $mins) {
            $maxMins = $maxMins - $mins;
        }

//        var_dump($maxHours . ":" .$maxMins); die();

        $min = $workingHours[0]->getOpeningAt();
        $max = $maxHours . ":" .$maxMins . ":00";


        return $this->json(['min' => $min,
            'max' => $max]);
    }
}