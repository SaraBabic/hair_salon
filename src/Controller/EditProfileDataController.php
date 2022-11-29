<?php

namespace App\Controller;

use App\Form\UserProfileForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditProfileDataController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/profile', name: 'app_user_profile')]
    public function userProfile(Request $request, EntityManagerInterface $em):Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserProfileForm::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Your data is successfully saved!');
        }

        return $this->render('profile/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }
}