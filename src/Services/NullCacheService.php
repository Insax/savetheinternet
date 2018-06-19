<?php

namespace App\Services;

class NullCacheService implements CacheServiceInterface
{
    private $content = [];

    public function set(string $key, string $value): void
    {
        $this->content[$key] = $value;
    }

    public function get(string $key): string
    {
        return $this->content[$key];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->content);
    }

    public function search(string $key, $limit = 0): array
    {
        $found = [];

        $hasWildCard = strpos($key, '*');
        foreach ($this->content as $iKey => $iValue) {
            if ($key === $iKey) {
                $found[] = $iKey;
            }

            if ($hasWildCard !== false && strpos($iKey, substr($key, 0, -1)) !== false) {
                $found[] = $iKey;
            }
        }

        return $found;
    }

    public function flush(): void
    {
        $this->content = [];
    }

    public function deleteWildcard(string $key): void
    {
        $hasWildCard = strpos($key, '*');
        foreach ($this->content as $iKey => $iValue) {
            if ($key === $iKey) {
                unset($this->content[$iKey]);
            }

            if ($hasWildCard !== false && strpos($iKey, substr($key, 0, -1)) !== false) {
                unset($this->content[$iKey]);
            }
        }
    }
}
