<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Repository\SalonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalonController extends AbstractController
{
    #[Route('/salon', name: 'app_salon')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $salons = $doctrine->getRepository(Salon::class)->findByActivity();

        return $this->render('salon/index.html.twig', [
            'salons' => $salons,
        ]);
    }

    #[Route('/salon/{id}', name:'app_salon_by_id')]
    public function salonById(SalonRepository $repository, int $id):Response
    {
        $salon = $repository->findOneBy(['id'=>$id]);

        return $this->render('salon/oneSalon.html.twig',[
            'salon'=>$salon
        ]);
    }
}
