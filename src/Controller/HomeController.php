<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SalonRepository;
use Doctrine\Persistence\ManagerRegistry;
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
    #[Route('/user/{id}', name: 'app_user')]
    public function user(SalonRepository $salonRepository, ManagerRegistry $doctrine, $id): Response
    {
        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        $salons = $salonRepository->findFiveBestRatedSalons();
        $cities = $salonRepository->findAllSalonCities();

        return $this->render('home/home.html.twig',[
            'salons' => $salons,
            'cities' => $cities,
            'user' => $user
        ]);
    }
    #[Route('/about_us', name: 'app_about_us')]
    public function aboutUs(SalonRepository $salonRepository): Response
    {
        return $this->render('about_us/index.html.twig',);
    }

}