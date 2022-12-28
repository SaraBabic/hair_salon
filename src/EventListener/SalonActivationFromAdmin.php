<?php

namespace App\EventListener;

use App\Entity\Salon;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SalonActivationFromAdmin
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function preUpdate(Salon $salon, PreUpdateEventArgs $args)
    {
        if ($args->hasChangedField('isActive') && $args->getNewValue('isActive') == true) {
            $email = (new TemplatedEmail())
                ->from(new Address('info@hairsalons.com', 'Hair Salon Administration'))
                ->to($salon->getOwner()->getEmail())
                ->subject('Salon Activation')
                ->htmlTemplate('admin/salonActivationMail.html.twig')
                ->context([
                    'salon_name' => $salon->getName(),
                    'owner' => $salon->getOwner()
                ]);
            try {
                $this->mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                print_r($e);
            }
        }
    }
}