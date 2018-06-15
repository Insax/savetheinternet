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

$routes->add('imprint', new Route('/imprint', array(
    '_controller' => 'App\\Controller\\IndexController::imprint',
    '_locale' => 'en_GB',
), array(
    '_locale' => implode('|', \App\EventSubscriber\getAvailableLanguages()),
)));

$routes->add('privacy', new Route('/privacy', array(
    '_controller' => 'App\\Controller\\IndexController::privacy',
    '_locale' => 'en_GB',
), array(
    '_locale' => implode('|', \App\EventSubscriber\getAvailableLanguages()),
)));

$routes->add('about', new Route('/about', array(
    '_controller' => 'App\\Controller\\IndexController::about',
    '_locale' => 'en_GB',
), array(
    '_locale' => implode('|', \App\EventSubscriber\getAvailableLanguages()),
)));

return $routes;
