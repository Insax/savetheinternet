<?php

namespace App\Services;


class NullCacheService implements CacheServiceInterface
{

    public function set(string $key, string $value): void
    {
    }

    public function get(string $key): string
    {
        return '';
    }

    public function has(string $key): bool
    {
        return false;
    }

    public function search(string $key, $limit = 0): array
    {
        return [];
    }
}