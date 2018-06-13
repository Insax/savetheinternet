<?php

namespace App\Controller;

use App\Services\TweetService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @var TweetService
     */
    private $tweetService;

    /**
     * IndexController constructor.
     */
    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }


    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $this->tweetService->loadLatestTweets();
        return $this->render('index/index.html.twig');
    }

    /**
     * @Route("/tweets/{amount}", name="tweets")
     * @param int $amount
     * @return JsonResponse
     */
    public function getTweets(int $amount = 10)
    {
        return new JsonResponse($this->tweetService->getTweets($amount));
    }
}
