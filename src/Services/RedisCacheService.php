<?php

namespace App\Services;

use Predis\Client;

class RedisCacheService implements CacheServiceInterface
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
        if (!isset($_SERVER['REDIS_HOST']) || null === $_SERVER['REDIS_HOST']) {
            return;
        }

        $redis = new Client(array(
            'scheme' => 'tcp',
            'host' => $_SERVER['REDIS_HOST'],
            'port' => $_SERVER['REDIS_PORT'],
        ));

        $this->redis = $redis;
    }

    public function set(string $key, string $value): void
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
        $found = array();
        do {
            $result = $this->redis->scan($iterator, array('MATCH '.$key));

            $iterator = (int) $result[0];
            unset($result[0]);

            $found[] = $result[1];

            if (0 !== $limit && \count($found) * 10 > $limit) {
                break;
            }
        } while (0 !== $iterator);

        $found = array_merge(...$found);

        return $found;
    }

    public function flush(): void
    {
        $this->redis->flushdb();
    }

    public function deleteWildcard(string $key): void
    {
        $this->redis->eval('return redis.call(\'del\', \'defaultKey\', unpack(redis.call(\'keys\', ARGV[1])))', 0, $key);
    }
}
