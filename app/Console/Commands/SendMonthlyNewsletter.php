<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\MonthlyNewsletter;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendMonthlyNewsletter extends Command
{
    protected $signature = 'newsletter:send';

    protected $description = 'Send the monthly newsletter to all users';

    public function handle()
    {
        // $users = User::all();

        $user = User::find(1);

        // foreach ($users as $user) {
        Mail::to($user->email)->send(new MonthlyNewsletter($user));
        // }

        $this->info('Monthly newsletter sent successfully!');
    }
}
