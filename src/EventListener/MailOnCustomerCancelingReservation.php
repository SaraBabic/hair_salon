<?php

namespace App\EventListener;

use App\Entity\HairdresserDetails;
use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailOnCustomerCancelingReservation
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function preUpdate(Reservation $reservation, PreUpdateEventArgs $args)
    {
        if ($args->hasChangedField('canceled') && $args->getNewValue('canceled') == true) {

            $email = (new TemplatedEmail())
                ->from(new Address('info@hairsalons.com', 'Hair Salon Administration'))
                ->to($reservation->getHairdresser()->getEmail())
                ->subject('Customer canceled appointment.')
                ->htmlTemplate('reservation/cancelReservationMail.html.twig')
                ->context([
                    'user' => $reservation->getCustomer()->getFirstName() . " " . $reservation->getCustomer()->getLastName(),
                    'date' => $reservation->getStartAt()
                ]);
            try {
                $this->mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                print_r($e);
            }
        }
    }
}