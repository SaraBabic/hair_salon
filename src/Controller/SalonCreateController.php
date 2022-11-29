<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Salon;
use Symfony\Component\HttpFoundation\File\File;
use App\Form\RegistrationFormType;
use App\Form\SalonCreateForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SalonCreateController extends AbstractController
{
    #[Route('/salon/create', name: 'app_salon_create')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        if($this->getUser()){
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(SalonCreateForm::class );
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $user = new User();
            $user->setFirstName($formData['firstName']);
            $user->setLastName($formData['lastName']);
            $user->setRoles(['ROLE_SALON_OWNER']);
            $user->setPhoneNumber($formData['phoneNumber']);
            $user->setEmail($formData['email']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $formData['password']
                )
            );
            $salon = new Salon();

            //image upload
            $imagePath = $form->get('salonImages')->getData();
            if($imagePath) {
                $originalFilename = pathinfo($imagePath->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imagePath->guessExtension();
                try {
                    $imagePath->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
                $salon->setImagePath($newFilename);
            }
            $salon->setName($formData['salonName']);
            $salon->setCity($formData['salonCity']);
            $salon->setAddress($formData['salonAddress']);
            $salon->setPhoneNumber($formData['salonPhoneNumber']);
            $salon->setDescription($formData['salonDescription']);
            $salon->setIsActive(0);
            $salon->setOwner($user);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->persist($salon);
            $entityManager->flush();

            $this->addFlash('success', 'You successfully sent your data. We will send you an email when it is approved!');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('salon_create/index.html.twig', [
            'salonCreateForm' => $form->createView(),
        ]);
    }
}
