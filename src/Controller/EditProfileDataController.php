<?php

namespace App\Controller;

use App\Entity\HairdresserDetails;
use App\Form\ChangePasswordForm;
use App\Form\HairdresserProfileForm;
use App\Form\UserProfileForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class EditProfileDataController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/profile', name: 'app_user_profile')]
    public function userProfile(Request $request, EntityManagerInterface $em, ManagerRegistry $doctrine):Response
    {
        $user = $this->getUser();
        $userRole = $this->getUser()->getRoles();

        $hairdresser = $doctrine->getRepository(HairdresserDetails::class)->findOneBy(['user' => $user]);

        $form = $this->createForm(UserProfileForm::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            if($request->get('biography')) {
                $hairdresser->setBiography($request->get('biography'));
                $em->persist($hairdresser);
            }
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Your data is successfully saved!');
        }

        return $this->render('profile/profile.html.twig', [
            'form' => $form->createView(),
            'role' => $userRole
        ]);
    }

    #[Route('/change_password', name: 'app_change_password')]
    public function changePassword(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher):Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordForm::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $form->get('password')->getData();
            $hashedPassword = $hasher->hashPassword($user,$password);
            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();
        }

        return $this->render('profile/changePassword.html.twig', [
            'form' => $form->createView()
        ]);
    }
}