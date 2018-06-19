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
        if (!isset($_SERVER['REDIS_HOST']) || $_SERVER['REDIS_HOST'] === null) {
            return;
        }

        $redis = new Client([
            'scheme' => 'tcp',
            'host'   => $_SERVER['REDIS_HOST'],
            'port'   => $_SERVER['REDIS_PORT'],
        ]);

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
        $found = [];
        do {
            $result = $this->redis->scan($iterator, ['MATCH '.$key]);

            $iterator = (int) $result[0];
            unset($result[0]);

            $found[] = $result[1];

            if ($limit !== 0 && \count($found) * 10 > $limit) {
                break;
            }
        } while ($iterator !== 0);

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
