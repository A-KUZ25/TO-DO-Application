<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;

interface TaskRepositoryInterface
{
    public function getPaginatedTasks(int $perPage): Paginator;
}
