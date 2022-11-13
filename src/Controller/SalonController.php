<?php

namespace App\Controller;

use App\Entity\Salon;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalonController extends AbstractController
{
    #[Route('/salon', name: 'app_salon')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $salons = $doctrine->getRepository(Salon::class)->findAll();


        return $this->render('salon/index.html.twig', [
            'salons' => $salons,
        ]);
    }
}
