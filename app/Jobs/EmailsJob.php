<?php

namespace App\Jobs;

use App\Mail\TaskNotificationMail;
use App\Models\Email;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailsJob implements ShouldQueue
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
        $emailQuery = Email::whereNull('sent_at')
            ->where(function ($query) {
                $query->where('scheduled_at', '<=', now())
                    ->orWhereNull('scheduled_at');
            });

        $emailQuery->chunkById(500, function ($emails) {
            /** @var Email $email */
            foreach ($emails as $email) {
                $mail = new TaskNotificationMail($email);

                try {
                    Mail::to($email->recipient)->send($mail);

                    $email->sent_at = now();
                    $email->save();
                } catch (\Throwable $exception) {
                    Log::error('Failed to send email: ' . $exception->getMessage());
                }
            }
        });
    }
}
