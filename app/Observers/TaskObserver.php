<?php

namespace App\Observers;

use App\Enums\TaskLogActionEnum;
use App\Models\Task;
use App\Models\TaskLog;
use Carbon\Carbon;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        $original = collect($task->toArray())
            ->only($task->getFillable())
            ->toArray();

        TaskLog::create([
            'task_id' => $task->id,
            'action' => TaskLogActionEnum::Create->value,
            'data_changes' => null,
            'data' => $original,
        ]);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $original = collect($task->getOriginal())
            ->only($task->getFillable())
            ->toArray();

        $changes = collect($task->getChanges())
            ->only($task->getFillable())
            ->toArray();

        // Make sure due_date changed
        if (isset($changes['due_date']) &&
            Carbon::create($original['due_date'])->format('Y-m-d H:i') === Carbon::create($changes['due_date'])->format('Y-m-d H:i')) {
            unset($changes['due_date']);
        }

        // If there are no changes in object do not log it.
        if (!count($changes)) {
            return;
        }

        TaskLog::create([
            'task_id' => $task->id,
            'action' => TaskLogActionEnum::Update->value,
            'data_changes' => $changes,
            'data' => null,
        ]);
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
