<?php

namespace App\DTO;

readonly class PaginateData
{
    public function __construct(
        public int $page,
        public int $perPage,
        public array $filters,
    ) {
    }

    public function getFilter(string $key): mixed
    {
        return $this->filters[$key] ?? null;
    }
}
