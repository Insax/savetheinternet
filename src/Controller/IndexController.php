<?php

namespace App\Controller;

use App\Kernel;
use App\Services\TweetService;
use Smalot\Github\Webhook\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @var TweetService
     */
    private $tweetService;

    /**
     * IndexController constructor.
     * @param TweetService $tweetService
     */
    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
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
    public function gallery(KernelInterface $kernel): Response
    {
        $base = realpath($kernel->getRootDir() . '/../public/build/static/gallery');
        $files = $base . '/files/';
        $preview = $base . '/preview/';

        $finder = new Finder();

        $finder->files()->depth('< 3')->name('/\.(png|jpg)$/i')->in($files);

        $galleryImages = [];

        foreach ($finder as $file) {
            $name = $file->getFilename();
            $langcode = basename(dirname($file->getRealPath()));
            $thumb = sprintf('%s/thumb_%s', $langcode, $name);

            if(!file_exists($preview . $thumb)) {
                $this->resizeImage($file, $preview . $thumb);
            }

            $galleryImages[] = [
                'name' => sprintf('%s/%s', $langcode, $name),
                'thumb' => $thumb,
                'langcode' => $langcode
            ];
        }

        return $this->render('gallery/index.html.twig', ['images' => $galleryImages]);
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

    private function resizeImage(SplFileInfo $file, $destinationName)
    {
        $imagick = new \Imagick($file->getRealPath());

        $imagick->resizeImage(453,640, 0, 1, true);

        $imageWidth = $imagick->getImageWidth();
        if($imagick->getImageHeight() > $imageWidth * 1.5) {
            $imagick->cropImage($imageWidth,$imageWidth * 1.5,0,0);
        }

        return $imagick->writeImage($destinationName);
    }
}
