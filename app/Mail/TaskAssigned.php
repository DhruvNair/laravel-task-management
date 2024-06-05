<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssigned extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    private $task_name;
    private $project_name;
    private $user_name;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->task_name = $data['task_name'];
        $this->project_name = $data['project_name'];
        $this->user_name = $data['user_name'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Task Assigned',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.task-assigned',
            with: [
                'task_name' => $this->task_name,
                'project_name' => $this->project_name,
                'user_name' => $this->user_name,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
