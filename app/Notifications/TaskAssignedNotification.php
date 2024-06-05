<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Jobs\SendTaskAssignedNotification;
use App\Mail\TaskAssigned;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    private Task $task;
    private Project $project;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
        $project = Project::find($this->task->project_id);
        $this->project = $project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): Mailable
    {
        return (new TaskAssigned([
            'task_name' => $this->task->title,
            'project_name' => $this->project->name,
            'user_name' => $notifiable->name,
        ]))->to($notifiable->email);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'task_name' => $this->task->title,
            'project_name' => $this->project->name,
            'user_name' => $notifiable->name,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
