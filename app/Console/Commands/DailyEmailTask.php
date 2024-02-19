<?php

namespace App\Console\Commands;

use App\Mail\DailyNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DailyEmailTask extends Command
{
    protected $signature = 'daily:email';
    protected $description = 'Send a daily email notification';

    public function handle()
    {
        $userEmail = 'noorkhaled935@gmail.com';
        Mail::to($userEmail)->send(new DailyNotification());
        $this->info('Daily Email is sent!!');
    }
}
