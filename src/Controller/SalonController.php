<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Repository\SalonRatingRepository;
use App\Repository\SalonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalonController extends AbstractController
{
    #[Route('/salon', name: 'app_salon')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $salons = $doctrine->getRepository(Salon::class)->findBy(['isActive'=> true]);
        $city = $request->get('city');
        if($city){
            $salons = $doctrine->getRepository(Salon::class)->findBy(['city'=>$city]);
        }

        return $this->render('salon/index.html.twig', [
            'salons' => $salons,
        ]);
    }

    #[Route('/salon/{id}/show', name:'app_salon_by_id')]
    public function salonById(SalonRepository $repository, SalonRatingRepository $ratingRepository, int $id):Response
    {
        $salon = $repository->findOneBy(['id'=>$id]);
        $salonRating = $ratingRepository->findAverageRatingForSalon($id);

        return $this->render('salon/oneSalon.html.twig',[
            'salon'=>$salon,
            'rating' => $salonRating[0]
        ]);
    }
}
