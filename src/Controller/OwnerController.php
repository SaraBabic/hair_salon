<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Entity\SalonServices;
use App\Entity\User;
use App\Form\SalonForm;
use App\Form\ServiceCreateForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class OwnerController extends AbstractController {
    //owner dashboard
    #[Route('/owner/{id}/dashboard', name: 'app_owner_dashboard')]
    public function index(ManagerRegistry $doctrine, $id):Response {
        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        $salon = $user->getSalon();

        return $this->render('owner/index.html.twig', [
            'salon' => $salon,
            'user' => $user,
        ]);
    }

    //Salon info
    #[Route('/owner/{id}/salon/{salon_id}/show', name: 'app_owner_salon_show')]
    public function owner_salon(ManagerRegistry $doctrine, $id, Request $request, EntityManagerInterface $em):Response {

        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        $salon = $user->getSalon();

        $form = $this->createForm(SalonForm::class, $salon);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $salon = $form->getData();
            $em->persist($salon);
            $em->flush();

            $this->addFlash('success', 'Your data is successfully saved!');
        }

        return $this->render('owner/owner_salon.html.twig', [
            'salon' => $salon,
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    //Salon Services
    #[Route('/owner/{id}/salon/{salon_id}/services', name: 'app_salon_services')]
    public function salon_services(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, UserInterface $user, $id ):Response {
        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        $salon = $user->getSalon();


        $form = $this->createForm(ServiceCreateForm::class);
        $form->handleRequest($request);
        $services = $doctrine->getRepository(SalonServices::class)->findBy(['salon' => $salon]);
        if($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $service = new SalonServices();
            $service->setName($formData['serviceName']);
            $service->setPrice($formData['servicePrice']);
            $service->setDuration($formData['serviceDuration']);
            $service->setSalon($salon);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('success', 'You successfully added a service to your salon!');
            return $this->redirectToRoute('app_salon_services', [
                'id' => $id,
                'salon_id' => $salon->getId(),
            ]);
        }
        return $this->render('owner/salon_services.html.twig', [
            'salon' => $salon,
            'user' => $user,
            'serviceCreateForm' => $form->createView(),
            'salon_services' => $services,
        ]);
    }
    #[Route('/owner/{id}/salon/{salon_id}/services/{service_id}/delete', name: 'delete_service', methods: ['GET'])]
    public function delete($service_id, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, $id): Response
    {
        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        $salon = $user->getSalon();
        $form = $this->createForm(ServiceCreateForm::class);
        $service = $doctrine->getRepository(SalonServices::class)->findAll();

        $salonServicesRepository = $doctrine->getRepository(SalonServices::class);
        /** @var SalonServices $salonService */
        $salonService = $salonServicesRepository->find($service_id);
        $entityManager->remove($salonService);
        $entityManager->flush();

        return $this->redirectToRoute('app_salon_services', [
            'id' => $id,
            'salon_id' => $salon->getId(),
        ]);
    }
}