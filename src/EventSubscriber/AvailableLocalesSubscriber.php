<?php

namespace App\EventSubscriber;

use Abraham\TwitterOAuth\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class AvailableLocalesSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig_Environment;


    /**
     * AvailableLocalesSubscriber constructor.
     * @param \Twig_Environment $twig_Environment
     */
    public function __construct(\Twig_Environment $twig_Environment)
    {
        $this->twig_Environment = $twig_Environment;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $languages = getAvailableLanguages();
        $this->twig_Environment->addGlobal('locales', $languages);

        // detect users language form browser
        $this->setVisitosLanguage($event, $languages);

        $codes = [];
        foreach ($languages as $language) {
            $parts = explode('_', $language);
            $codes[$language] = $parts;
        }


        $this->twig_Environment->addGlobal('localeCodes', $codes);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }

    private function setVisitosLanguage(GetResponseEvent $event, array $languages)
    {
        // some logic to determine the $locale
        $request = $event->getRequest();
        $locale = $request->getLocale(); // browser locale

        if (!is_null($request->query->get('_locale')))
        {
            $request->setLocale($request->query->get('_locale'));
        }
        elseif (in_array($locale, $languages)) {
            $request->setLocale($locale);
        } else {
            $request->setLocale('en_GB');
        }
    }
}

function getAvailableLanguages()
{
    $translationFiles = scandir(__DIR__ . '/../../translations', SCANDIR_SORT_NONE);

    $languages = [];
    foreach ($translationFiles as $file) {
        $parts = explode('.', $file);

        if (\count($parts) !== 3) {
            continue;
        }

        if (empty($parts[1])) {
            continue;
        }

        $languages[] = $parts[1];
    }

    return $languages;
}
