<?php

namespace App\EventSubscriber;

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
}

function getAvailableLanguages() {
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