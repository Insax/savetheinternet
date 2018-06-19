<?php

namespace App\Services;

use Abraham\TwitterOAuth\TwitterOAuth;

class TweetService
{
    private $twitterOAuth;

    /**
     * @var CacheServiceInterface
     */
    private $cache;

    /**
     * @var bool
     */
    private $enabled = false;

    /**
     * TweetService constructor.
     *
     * @param CacheServiceInterface $cache
     */
    public function __construct(CacheServiceInterface $cache)
    {
        if (!isset($_SERVER['OAUTH_KEY'], $_SERVER['OAUTH_SECRET']) || null === $_SERVER['OAUTH_KEY'] || null === $_SERVER['OAUTH_SECRET']) {
            return;
        }

        $this->enabled = true;
        $this->cache = $cache;
        $this->twitterOAuth = new TwitterOAuth($_SERVER['OAUTH_KEY'], $_SERVER['OAUTH_SECRET']);
    }

    public function loadLatestTweets(): void
    {
        if (!$this->enabled) {
            return;
        }

        $lastTweetLoad = new \DateTime('1970');
        $fiveMinAgo = new \DateTime('5min ago');

        if ($this->cache->has('lastTweetLoad')) {
            $lastTweetLoad = unserialize($this->cache->get('lastTweetLoad'), array('allowed_classes' => array(\DateTime::class)));
        }

        if ($lastTweetLoad->getTimestamp() > $fiveMinAgo->getTimestamp()) {
            return;
        }

        $this->deleteAllTweets();

        if (!isset($_SERVER['TWITTER_SEARCH']) || null === $_SERVER['TWITTER_SEARCH']) {
            return;
        }

        $result = $this->twitterOAuth->get('search/tweets', array('q' => $_SERVER['TWITTER_SEARCH'], 'count' => 100));

        if (property_exists($result, 'errors') && null !== $result->errors) {
            $this->cache->set('lastTweetLoad', serialize(new \DateTime('now')));

            return;
        }

        foreach ($result->statuses as $tweet) {
            $tweetKey = 'tweet_'.$tweet->id;

            $hasItem = $this->cache->has($tweetKey);

            if (true === $hasItem) {
                break;
            }

            $this->cache->set($tweetKey, json_encode((array) $tweet));
        }

        $this->cache->set('lastTweetLoad', serialize(new \DateTime('now')));
    }

    public function getTweets($limit = 15): array
    {
        if (false === $this->enabled) {
            return array();
        }

        if ($this->cache instanceof NullCacheService) {
            $this->loadLatestTweets();
        }

        $found = $this->cache->search('tweet_*', $limit);

        $tweets = array();
        foreach ($found as $tweet) {
            $tweets[] = json_decode($this->cache->get($tweet));
        }

        return $tweets;
    }

    public function deleteAllTweets(): void
    {
        $this->cache->deleteWildcard('tweet_*');
    }
}
