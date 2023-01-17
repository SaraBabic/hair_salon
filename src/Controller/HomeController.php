<?php

namespace App\Controller;

use App\Repository\SalonRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SalonRepository $salonRepository): Response
    {
        $salons = $salonRepository->findFiveBestRatedSalons();
        $cities = $salonRepository->findAllSalonCities();

        return $this->render('home/home.html.twig',[
            'salons' => $salons,
            'cities' => $cities
        ]);
    }
    #[Route('/about_us', name: 'app_about_us')]
    public function aboutUs(SalonRepository $salonRepository): Response
    {
        return $this->render('about_us/index.html.twig',);
    }

}