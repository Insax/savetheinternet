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
     *
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
        $this->setVisitorLanguage($event, $languages);

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

    private function setVisitorLanguage(GetResponseEvent $event, array $languages)
    {
        // some logic to determine the $locale
        $request = $event->getRequest();
        $locale = $request->getLocale(); // browser locale

        if (!is_null($request->query->get('_locale'))) {
            $request->setLocale($request->query->get('_locale'));
        } elseif (in_array($locale, $languages)) {
            $request->setLocale($locale);
        } else {
            $request->setLocale('en_GB');
        }
    }
}

function getAvailableLanguages()
{
    $languageOrder = [];
    if (isset($_SERVER['LANG_ORDER'])) {
        $languageOrder = explode(',', $_SERVER['LANG_ORDER']);
    }

    $translationFiles = scandir(__DIR__.'/../../translations', SCANDIR_SORT_NONE);

    $languages = [];
    $otherLangs = [];
    foreach ($translationFiles as $file) {
        $parts = explode('.', $file);

        if (\count($parts) !== 3) {
            continue;
        }

        if (empty($parts[1])) {
            continue;
        }

        if (\in_array($parts[1], $languageOrder, true)) {
            $position = \array_flip($languageOrder)[$parts[1]];

            $languages[$position] = $parts[1];
        } else {
            $otherLangs[] = $parts[1];
        }

    }

    ksort($languages);

    foreach ($otherLangs as $otherLang) {
        $languages[] = $otherLang;
    }

    return $languages;
}
