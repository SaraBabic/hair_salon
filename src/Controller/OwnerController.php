<?php

namespace App\Controller;

use App\Entity\HairdresserDetails;
use App\Entity\Reservation;
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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\SalonWorkingHours;

class OwnerController extends AbstractController {
    //owner dashboard
    #[Route('/owner/{id}/dashboard', name: 'app_owner_dashboard')]
    public function index(ManagerRegistry $doctrine, $id):Response {
        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
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
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
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
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
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
    //Delete Service
    #[Route('/owner/{id}/salon/{salon_id}/services/{service_id}/delete', name: 'delete_service', methods: ['GET'])]
    public function delete($service_id, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, $id): Response
    {
        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
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
    //Custom working hours
    #[Route('/owner/{id}/salon/{salon_id}/working_hours', name: 'app_owner_working_hours')]
    public function working_hours(ManagerRegistry $doctrine, $id, Request $request, EntityManagerInterface $em):Response {

        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
        $salon = $user->getSalon();

        /** @var SalonWorkingHours[] $existingWorkingHours*/
        $existingWorkingHours = $doctrine->getRepository(SalonWorkingHours::class)->findBy(['salon' => $salon->getId()]);

        $form = $this->createForm(WorkingHoursForm::class, null,
            ['hours' => $existingWorkingHours]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityData = [];

            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            foreach ($days as $day) {
                $entityData[] = [
                    'opening_at' => $data["{$day}From"],
                    'closing_at' => $data["{$day}To"]
                ];
            }

            $swhRepo = $doctrine->getRepository(SalonWorkingHours::class);
            $swhSalonEntries = $swhRepo->findBy(['salon' => $salon]);
            /** @var SalonWorkingHours $swhSalonEntry */
            foreach ($swhSalonEntries as $swhSalonEntry) {
                $em->remove($swhSalonEntry);
            }
            $em->flush();

            foreach ($entityData as $index => $workingHours) {
                $wh = new SalonWorkingHours();
                $wh->setSalon($salon);
                $wh->setOpeningAt($workingHours['opening_at']);
                $wh->setClosingAt($workingHours['closing_at']);
                $wh->setDay($index+1);
                $em->persist($wh);
            }
            $em->flush();

            $this->addFlash('success', 'Your data is successfully saved!');

            return $this->render('owner/working_hours.html.twig', [
                'salon' => $salon,
                'user' => $user,
                'form' => $form->createView()
            ]);
        }

        return $this->render('owner/working_hours.html.twig', [
            'salon' => $salon,
            'user' => $user,
            'form' => $form->createView(),
            'workingHours' => $existingWorkingHours
        ]);
    }
    // Hairdressers.
    #[Route('/owner/{id}/salon/{salon_id}/hairdressers', name: 'app_owner_hairdressers')]
    public function owner_hairdressers(ManagerRegistry $doctrine, $id, Request $request, EntityManagerInterface $em):Response {

        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
        $salon = $user->getSalon();

        $hairdressersRepository = $doctrine->getRepository(HairdresserDetails::class)->find($salon);
        $hairdressers = $salon->getHairdresser();
        $numberOfHairdressers = count($hairdressers);

        return $this->render('owner/hairdressers.html.twig', [
            'salon' => $salon,
            'hairdressers' => $hairdressers,
            'user' => $user,
            'number_of_hairdressers' => $numberOfHairdressers,
        ]);
    }

    // Create hairdresser.
    #[Route('/owner/{id}/salon/{salon_id}/hairdressers/create', name: 'app_owner_hairdressers_create')]
    public function owner_create_hairdressers(UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine, $id, Request $request, EntityManagerInterface $em):Response {

        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
        $salon = $user->getSalon();

        $form = $this->createForm(HairdresserCreateForm::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $user = new User();
            $hairdresserDetails = new HairdresserDetails();

            $user->setFirstName($formData['firstName']);
            $user->setLastName($formData['lastName']);
            $user->setEmail($formData['email']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(["ROLE_HAIRDRESSER"]);
            $user->setIsVerified(true);
            $user->setPhoneNumber('Your phone number');
            $em->persist($user);

            $hairdresserDetails->setUser($user);
            $hairdresserDetails->setSalon($salon);
            $hairdresserDetails->setBiography("Short description of you.");
            $hairdresserDetails->setIsActive(true);
            $em->persist($hairdresserDetails);
            $em->flush();

            $user->setHairdresserDetails($hairdresserDetails);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'You successfully added a hairdresser to your salon!');
            return $this->redirectToRoute('app_owner_hairdressers', [
                'id' => $id,
                'salon_id' => $salon->getId(),
            ]);
        }



        return $this->render('owner/hairdresser_create.html.twig', [
            'salon' => $salon,
            'hairdresserCreateForm' => $form->createView(),
        ]);
    }

    // Activate/Deactivate hairdresser
    #[Route('/owner/{id}/salon/{salon_id}/hairdresser/{hairdresser_id}/toggle-status', name: 'toggle_user_status', methods: ['GET'])]
    public function toggle_status($hairdresser_id, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, $id): Response
    {
        $hairdresserRepository = $doctrine->getRepository(HairdresserDetails::class);
        /** @var HairdresserDetails $hairdresser_details */
        $hairdresser_details = $hairdresserRepository->find($hairdresser_id);

        if($hairdresser_details->isIsActive()) {
            $hairdresser_details->setIsActive(false);
        }
        else {
            $hairdresser_details->setIsActive(true);
        }

        $salon = $hairdresser_details->getSalon();

        $entityManager->flush();

        return $this->redirectToRoute('app_owner_hairdressers', [
            'id' => $id,
            'salon_id' => $salon->getId()
        ]);
    }

    #[Route('/owner/{id}/salon/{salon_id}/reservations', name: 'app_reservations')]
    public function salon_reservations( ManagerRegistry $doctrine, EntityManagerInterface $entityManager, $id): Response
    {
        $userRepository = $doctrine->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($id);
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
        $salon = $user->getSalon();

        $reservations = $doctrine->getRepository(Reservation::class)->findBy(['salon' => $salon] );
        return $this->render('owner/reservations.html.twig', [
            'id' => $id,
            'salon' => $salon,
            'salon_id' => $salon->getId(),
            'reservations' => $reservations,
        ]);
    }

}