<?php

namespace App\Controller;

use App\Services\GalleryService;
use App\Services\TweetService;
use Smalot\Github\Webhook\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;

class IndexController extends Controller
{
    /**
     * @var TweetService
     */
    private $tweetService;

    /**
     * @var GalleryService
     */
    private $galleryService;

    /**
     * IndexController constructor.
     * @param TweetService $tweetService
     */
    public function __construct(TweetService $tweetService, GalleryService $galleryService)
    {
        $this->tweetService = $tweetService;
        $this->galleryService = $galleryService;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('index/index.html.twig');
    }

    /**
     * @return Response
     */
    public function imprint(): Response
    {
        return $this->render('imprint/index.html.twig');
    }

    /**
     * @return Response
     */
    public function privacy(): Response
    {
        return $this->render('privacy/index.html.twig');
    }

    /**
     * @return Response
     */
    public function gallery(): Response
    {

        return $this->render('gallery/index.html.twig', ['images' => $this->galleryService->getGallery()]);
    }

    /**
     * @return Response
     */
    public function about(): Response
    {
        return $this->render('about/index.html.twig');
    }

    /**
     * @return Response
     */
    public function mep(): Response // Contact your MEP page
    {
        return $this->render('mep/index.html.twig');
    }

    /**
     * @return Response
     */
    public function resources(): Response
    {
        return $this->render('resources/index.html.twig');
    }

    /**
     * @Route("/tweets/{amount}", name="tweets")
     * @param int $amount
     * @return JsonResponse
     */
    public function getTweets(int $amount = 10): JsonResponse
    {
        $response = new JsonResponse($this->tweetService->getTweets($amount));

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $this->container->get('event_dispatcher')->addListener(KernelEvents::TERMINATE, function () {
            $this->tweetService->loadLatestTweets();
        });

        return $response;
    }

    /**
     * @Route("/update", name="update", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $dispatcher = $this->get('event_dispatcher');
        $webhook = new Webhook($dispatcher);
        $event = $webhook->parseRequest($request, $_SERVER['WEBHOOK_SECRET']);

        exec('cd ' . __DIR__ . '/../../; git pull');
        exec('cd ' . __DIR__ . '/../../; composer install');
        exec('cd ' . __DIR__ . '/../../; yarn install');
        exec('cd ' . __DIR__ . '/../../; yarn run build');
        exec('cd ' . __DIR__ . '/../../; php bin/console cache:clear');

        return new Response();
    }
}
