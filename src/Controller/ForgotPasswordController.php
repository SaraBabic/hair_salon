<?php

namespace App\Controller;

use App\Form\ChangePasswordForm;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class ForgotPasswordController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    #[Route('/forgot_password', name: 'app_forgot_password')]
    public function forgotPassword():Response
    {
        return $this->render('security/forgotPassword.html.twig');
    }

    #[Route('/forgot_password/email', name: 'app_forgot_password_send_mail')]
    public function sendMailForgotPassword(Request $request, UserRepository $userRepository, EmailVerifier $emailVerifier)
    {
        $user = $userRepository->findOneBy(['email' => $request->get('email')]);
        $emailVerifier->sendEmailConfirmation('app_forgot_password_change', $user,
            (new TemplatedEmail())
                ->from(new Address('info@hairsalons.com', 'Hair Salon Administration'))
                ->to($user->getEmail())
                ->subject('You want to change password?')
                ->htmlTemplate('security/forgotPassEmail.html.twig')
        );

        $this->addFlash('success', 'We have sent you mail for changing your password!');
        return $this->redirectToRoute('app_forgot_password');
    }

    #[Route('/forgot_password/change/{id}', name: 'app_forgot_password_change')]
    public function forgotPasswordChange(int $id, Request $request, EntityManagerInterface $em, UserRepository $userRepository, UserPasswordHasherInterface $hasher, VerifyEmailHelperInterface $verifyEmailHelper):Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);
        if(!$user){
            $this->addFlash('error', 'User with this email does not exist.');
            return $this->redirectToRoute('app_forgot_password');
        }

        try {
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                $user->getId(),
                $user->getEmail()
            );
        }catch (VerifyEmailExceptionInterface $exception){
            $this->addFlash('error', 'There was the problem with link, try again.');
            return $this->redirectToRoute('app_forgot_password');
        }

        $form = $this->createForm(ChangePasswordForm::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $form->get('password')->getData();
            $hashedPassword = $hasher->hashPassword($user,$password);
            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'You have successfully changed your password. Now you can log in!');
            return  $this->redirectToRoute('app_login');
        }

        return $this->render('profile/changePassword.html.twig', [
            'form' => $form->createView()
        ]);
    }
}