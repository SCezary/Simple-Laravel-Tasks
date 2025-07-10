<?php

namespace App\Models;

use App\Enums\TaskLogActionEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $task_id
 * @property TaskLogActionEnum $action
 * @property array|null $data
 * @property array|null $data_changes
 * @property Carbon $created_at
 * @property-read Task $task
 * @method static Builder<static>|TaskLog newModelQuery()
 * @method static Builder<static>|TaskLog newQuery()
 * @method static Builder<static>|TaskLog query()
 * @method static Builder<static>|TaskLog whereChanges($value)
 * @method static Builder<static>|TaskLog whereCreatedAt($value)
 * @method static Builder<static>|TaskLog whereId($value)
 * @method static Builder<static>|TaskLog wherePreviousData($value)
 * @method static Builder<static>|TaskLog whereTaskId($value)
 * @mixin \Eloquent
 */
class TaskLog extends Model
{
    protected $fillable = [
        'task_id',
        'action',
        'data_changes',
        'data'
    ];

    public $timestamps = false;

    protected $casts = [
        'data_changes' => 'array',
        'data' => 'array',
        'action' => TaskLogActionEnum::class,
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
