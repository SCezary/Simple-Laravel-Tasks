<?php

namespace App\Models;

use App\Enums\TaskLogActionEnum;
use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Helpers\TaskHelper;
use App\Observers\TaskObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $priority
 * @property string $status
 * @property string $due_date
 * @property int $user_id
 * @property int $notified
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder<static>|Task forCurrentUser()
 * @method static Builder<static>|Task newModelQuery()
 * @method static Builder<static>|Task newQuery()
 * @method static Builder<static>|Task query()
 * @method static Builder<static>|Task search()
 * @method static Builder<static>|Task whereCreatedAt($value)
 * @method static Builder<static>|Task whereDescription($value)
 * @method static Builder<static>|Task whereDueDate($value)
 * @method static Builder<static>|Task whereId($value)
 * @method static Builder<static>|Task whereName($value)
 * @method static Builder<static>|Task wherePriority($value)
 * @method static Builder<static>|Task whereStatus($value)
 * @method static Builder<static>|Task whereUpdatedAt($value)
 * @method static Builder<static>|Task whereUserId($value)
 * @method static Builder<static>|Task whereNotified($value)
 * @property-read Collection<int, SharedTasks> $sharedTasks
 * @property-read int|null $shared_tasks_count
 * @method static Builder<static>|Task bySharedToken(string $token)
 * @property-read Collection<int, \App\Models\TaskLog> $logs
 * @property-read int|null $logs_count
 * @property-read Collection<int, SharedTasks> $sharedNotExpiredTasks
 * @property-read int|null $shared_not_expired_tasks_count
 * @mixin \Eloquent
 */

#[ObservedBy(TaskObserver::class)]
class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'priority',
        'status',
        'due_date',
        'notified'
    ];

    protected $guarded = [
        'user_id'
    ];

    protected $casts = [
        'priority' => TaskPriorityEnum::class,
        'status' => TaskStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sharedTasks(): HasMany
    {
        return $this->hasMany(SharedTasks::class);
    }

    public function sharedNotExpiredTasks(): HasMany
    {
        return $this->sharedTasks()->where('expires_at', '>', Carbon::now());
    }

    public function logs(): HasMany
    {
        return $this->hasMany(TaskLog::class)->orderBy('created_at', 'asc');
    }

    /**
     * Return all sorted logs as array, and it is mapping merged changes with task to 'merged_data' key in array
     *      and prev_data with previous snapshot of task.
     * @return array
     */
    public function mappedLogs(): array
    {
        $data = [];
        $result = [];

        /** @var TaskLog $log */
        foreach ($this->logs as $log) {
            if ($log->action === TaskLogActionEnum::Create) {
                $prevData = [];
                $data = $log->data;
            } else {
                $prevData = $data;
                $data = [
                    ...$data,
                    ...$log->data_changes,
                ];
            }

            $result[] = [
                ...$log->toArray(),
                'merged_data' => $data,
                'prev_data' => $prevData,
            ];
        }

        return $result;
    }

    public function scopeBySharedToken(Builder $query, string $token): Builder
    {
        return $query->whereHas('sharedTasks', function (Builder $query) use ($token) {
            $query->where('token', $token)
                ->where('expires_at', '>', Carbon::now());
        });
    }

    public function scopeForCurrentUser(Builder $query): Builder
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeSearch(Builder $query, array $requestParams): Builder
    {
        if (!empty($requestParams['name'])) {
            $query->where('name', 'like', '%' . $requestParams['name'] . '%');
        }

        if (!empty($requestParams['status'])) {
            $query->where('status', $requestParams['status']);
        }

        if (!empty($requestParams['priority'])) {
            $query->where('priority', $requestParams['priority']);
        }

        if (!empty($requestParams['due_date-from'])) {
            $query->where('due_date', '>=', $requestParams['due_date-from']);
        }

        if (!empty($requestParams['due_date-to'])) {
            $query->where('due_date', '<=', $requestParams['due_date-to']);
        }

        $orderFieldsKeys = array_keys(TaskHelper::ORDER_FIELDS);
        if (!empty($requestParams['order']) && in_array($requestParams['order'], $orderFieldsKeys)) {
            $orderParts = explode('-', $requestParams['order']);

            $orderField = strtolower($orderParts[0] ?? '');
            $orderDirection = strtolower($orderParts[1] ?? '');
            $query->orderBy($orderField, $orderDirection);
        }

        return $query;
    }
}
