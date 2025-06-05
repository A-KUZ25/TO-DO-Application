<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class TaskRepository implements TaskRepositoryInterface
{

    public function getPaginatedTasks(int $perPage): Paginator
    {
        return DB::table('tasks')
            ->select(['id', 'title', 'is_complete'])
            ->orderBy('id')
            ->simplePaginate($perPage);
    }
}
