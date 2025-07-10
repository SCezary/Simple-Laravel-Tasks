<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $task_id
 * @property string $token
 * @property string $expires_at
 * @method static Builder<static>|SharedTasks newModelQuery()
 * @method static Builder<static>|SharedTasks newQuery()
 * @method static Builder<static>|SharedTasks query()
 * @method static Builder<static>|SharedTasks whereExpiresAt($value)
 * @method static Builder<static>|SharedTasks whereId($value)
 * @method static Builder<static>|SharedTasks whereTaskId($value)
 * @method static Builder<static>|SharedTasks whereToken($value)
 * @property-read Task $task
 * @mixin \Eloquent
 */
class SharedTasks extends Model
{
    protected $table = 'shared_tasks';

    public $timestamps = false;

    protected $fillable = [
        'expires_at',
    ];

    protected $guarded = [
        'task_id',
        'token'
    ];

    public function task(): belongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
