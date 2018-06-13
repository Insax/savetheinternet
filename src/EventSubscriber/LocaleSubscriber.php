<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $locale = $request->get('locale');
        $session = $request->getSession();

        if ($session !== null) {
            $request->setSession(new Session());
        }

        if ($locale !== null) {
            $session->set('locale', $locale);
        }

        $request->setLocale($session->get('locale'));
    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered before (i.e. with a higher priority than) the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 20)),
        );
    }
}