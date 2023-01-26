<?php

namespace App\EventListener;

use App\Entity\HairdresserDetails;
use App\Entity\User;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailOnHairdresserCreatingBySalonOwner
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function postPersist(HairdresserDetails $details, PostPersistEventArgs $args)
    {
        if ($args->getObject()) {
            /** @var User $user */
            $user = $details->getUser();
            $user->setHairdresserDetails($details);
            $args->getObjectManager()->persist($user);
            $args->getObjectManager()->flush(); //ne ubaci?

            $email = (new TemplatedEmail())
                ->from(new Address('info@hairsalons.com', 'Hair Salon Administration'))
                ->to($user->getEmail())
                ->subject('You are our hairdresser!')
                ->htmlTemplate('owner/newHairdresserEmail.html.twig')
                ->context([
                    'user' => $user->getFirstName() . " " . $user->getLastName()
                ]);
            try {
                $this->mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                print_r($e);
            }
        }
    }
}