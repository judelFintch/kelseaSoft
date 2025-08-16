<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\UpdateAvailable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendUpdateNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-update-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the update available notification to all users.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        Notification::send($users, new UpdateAvailable());
        $this->info('Successfully sent the update notification to ' . $users->count() . ' users.');
    }
}