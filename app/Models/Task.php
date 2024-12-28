<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed|string $title
 * @property mixed|string $detail
 * @property mixed|string $status
 * @property mixed $id
 * @method static find(int $id)
 * @method static where(string $string, int $int)
 */
class Task extends Model
{
    protected $fillable = [
        'title',
        'detail',
        'status'
    ];

    public function userTasks(): HasMany
    {
        return $this->hasMany(UserTask::class);
    }
}
