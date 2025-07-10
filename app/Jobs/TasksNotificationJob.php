<?php

namespace App\Jobs;

use App\Enums\EmailTypesEnum;
use App\Models\Email;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class TasksNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $taskQuery = Task::where(function ($query) {
                $query->whereNull('notified')
                    ->orWhere('notified', 0);
            })
            ->where('due_date', '<=', (now())->modify('+1 day')->format('Y-m-d 23:59:59'))
            ->where('due_date', '>=', (now())->format('Y-m-d 00:00:00'));

        // Retrieve 100 tasks per chunk
        $taskQuery->chunkById(100, function (Collection $tasks) {
            $emails = [];

            // Prepare emails
            foreach ($tasks as $task) {
                $emails[] = [
                    'recipient' => $task->user->email,
                    'subject' => 'Your task is due soon',
                    'type' => EmailTypesEnum::TaskNotification,
                    'data' => json_encode([
                        'name' => $task->name,
                        'user' => $task->user->name,
                        'due_date' => $task->due_date,
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Make sure all requests are done
            DB::transaction(function () use ($emails, $tasks) {
                // Set tasks as notified
                Task::whereIn('id', $tasks->pluck('id'))->update(['notified' => true]);

                // Add emails
                DB::table('emails')->insert($emails);
            });
        });
    }
}
