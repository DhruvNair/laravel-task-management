<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\TaskAssignedNotification;

class SendTaskAssignedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private User $user;
    private Task $task;

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->user = User::find($this->task->assigned_to);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->user !== null){
            $this->user->notify(new TaskAssignedNotification($this->task));
        }
    }
}
