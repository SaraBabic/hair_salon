<?php

namespace App\EventSubscriber;

use App\Security\UserLoginMarking;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LoginSuccess implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private UserLoginMarking $loginMarking;

    public function __construct(UserLoginMarking $loginMarking){
        $this->loginMarking = $loginMarking;
    }

    public function onLogin(LoginSuccessEvent $event){
        $user = $event->getUser();
        $this->loginMarking->makeUserLog($user);
    }

    public static function getSubscribedEvents()
    {
        return [
          LoginSuccessEvent::class => 'onLogin'
        ];
    }
}