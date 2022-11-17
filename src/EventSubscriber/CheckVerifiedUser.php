<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

class CheckVerifiedUser implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{

    public function onCheckPassport(CheckPassportEvent $event)
    {
        $passport = $event->getPassport();
        if (!$passport instanceof Passport) {
            throw new \Exception('Unexpected passport type');
        }
        $user = $passport->getUser();
        if (!$user instanceof User) {
            throw new \Exception('Unexpected user type');
        }
        if (!$user->isVerified()) {
            throw new CustomUserMessageAuthenticationException('Please verify your account before logging in.');
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -10 ]
            //-10(bilo koji negativan broj) -> Thanks to this, the user will need to
            // enter a valid email and a valid password before our listener is called.
        ];
    }
}