<?php

namespace App\Repositories\Interfaces;

interface NotionRepositoryInterface
{
    public function database(string $databaseId): array;
}
