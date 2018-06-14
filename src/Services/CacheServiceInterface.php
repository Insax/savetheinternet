<?php

namespace App\Services;

interface CacheServiceInterface
{
    public function set(string $key, string $value): void;

    public function get(string $key): string;

    public function has(string $key): bool;

    public function search(string $key, $limit = 0): array;

    public function flush(): void;

    public function deleteWildcard(string $key): void;
}
