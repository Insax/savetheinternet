<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('index', new Route('/{_locale}', array(
    '_controller' => 'App\\Controller\\IndexController::index',
    '_locale' => 'en_GB',
), array(
    '_locale' => implode('|', \App\EventSubscriber\getAvailableLanguages()),
)));

return $routes;
