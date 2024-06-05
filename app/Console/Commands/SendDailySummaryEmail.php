<?php

namespace App\Console\Commands;

use App\Mail\DailySummary;
use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailySummaryEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-summary-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the daily summary email to the users.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Send the daily summary email to the users.
        User::all()->each(function (User $user) {
            // Send the daily summary email to the user.
            $tasks = Task::where('assigned_to', $user->id)->get();
            Mail::to($user->email)->send(new DailySummary([
                'user_name' => $user->name,
                'tasks' => $tasks,
            ]));
        });
    }
}
