<?php

namespace App\Services;

use Predis\Client;

class RedisCacheService
{

    /**
     * @var Client
     */
    private $redis;

    /**
     * RedisCacheService constructor.
     */
    public function __construct()
    {
        if ($_SERVER['REDIS_HOST'] === null) {
            $this->redis = null;
            return;
        }

        $redis = new Client([
            'scheme' => 'tcp',
            'host' => $_SERVER['REDIS_HOST'],
            'port' => $_SERVER['REDIS_PORT'],
        ]);

        $this->redis = $redis;
    }

    public function set(string $key, string $value)
    {
        $this->redis->set($key, $value);
    }

    public function get(string $key): string
    {
        return $this->redis->get($key);
    }

    public function has(string $key): bool
    {
        return $this->redis->exists($key);
    }

    public function search(string $key, $limit = 0): array
    {
        $iterator = 0;
        $found = [];
        do {
            $result = $this->redis->scan($iterator, ['MATCH ' . $key]);

            $iterator = (int)$result[0];
            unset($result[0]);

            $found[] = $result[1];

            if ($limit !== 0 && \count($found) * 10 > $limit) {
                break;
            }

        } while ($iterator !== 0);

        $found = array_merge(...$found);

        return $found;
    }
}