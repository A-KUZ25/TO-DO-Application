<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes,
        HasFactory;

    protected $guarded = [];

    public function scopeStatus($query, ?bool $isCompleted, bool $filterByStatus)
    {
        if ($filterByStatus) {
            return $query->where('is_completed', $isCompleted);
        }

        return $query;
    }
}
