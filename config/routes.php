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

$routes->add('imprint', new Route('/{_locale}/imprint', array(
    '_controller' => 'App\\Controller\\IndexController::imprint',
    '_locale' => 'en_GB',
), array(
    '_locale' => implode('|', \App\EventSubscriber\getAvailableLanguages()),
)));

$routes->add('privacy', new Route('/{_locale}/privacy', array(
    '_controller' => 'App\\Controller\\IndexController::privacy',
    '_locale' => 'en_GB',
), array(
    '_locale' => implode('|', \App\EventSubscriber\getAvailableLanguages()),
)));

$routes->add('about', new Route('/{_locale}/about', array(
    '_controller' => 'App\\Controller\\IndexController::about',
    '_locale' => 'en_GB',
), array(
    '_locale' => implode('|', \App\EventSubscriber\getAvailableLanguages()),
)));

$routes->add('gallery', new Route('/{_locale}/gallery', array(
    '_controller' => 'App\\Controller\\IndexController::gallery',
    '_locale' => 'en_GB',
), array(
    '_locale' => implode('|', \App\EventSubscriber\getAvailableLanguages()),
)));

$routes->add('mep', new Route('/{_locale}/contact-your-mep', array(
    '_controller' => 'App\\Controller\\IndexController::mep',
    '_locale' => 'en_GB',
), array(
    '_locale' => implode('|', \App\EventSubscriber\getAvailableLanguages()),
)));

$routes->add('resources', new Route('/{_locale}/resources', array(
    '_controller' => 'App\\Controller\\IndexController::resources',
    '_locale' => 'en_GB',
), array(
    '_locale' => implode('|', \App\EventSubscriber\getAvailableLanguages()),
)));

return $routes;
