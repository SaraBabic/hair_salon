<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Security\AccountNotVerifiedAuthenticationException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

class CheckVerifiedUser implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

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
            throw new AccountNotVerifiedAuthenticationException();
        }
    }

    public function onLoginFailure(LoginFailureEvent $event)
    {
        if($event->getException() instanceof AccountNotVerifiedAuthenticationException){
            $response = new RedirectResponse(
                $this->router->generate('app_verify_resend_email', [
                    'id' => $event->getPassport()->getUser()->getId()
                ])
            );
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -10 ],
            //-10(bilo koji negativan broj) -> Thanks to this, the user will need to
            // enter a valid email and a valid password before our listener is called.
            LoginFailureEvent::class => 'onLoginFailure',
        ];
    }
}