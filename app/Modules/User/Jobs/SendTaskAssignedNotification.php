<?php

namespace App\Modules\User\Jobs;

use App\Models\Task;
use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\User\Notifications\TaskAssignedNotification;
use Illuminate\Support\Facades\Log;
class SendTaskAssignedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly Task $task,
        public readonly Admin $admin
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->task->assignee->notify(
                new TaskAssignedNotification($this->task, $this->admin)
            );
        } catch (\Exception $e) {
            Log::error('Failed to send task assignment notification: ' . $e->getMessage());
        }
    }
}
