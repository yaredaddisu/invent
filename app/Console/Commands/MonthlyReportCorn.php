<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

 use App\Models\User;
use Mail;
use \Carbon\Carbon;
use App\Mail\MonthlyReportMail;

class MonthlyReportCorn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthlyreport:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::query()->get();
        
        foreach($users as $key => $user)
        {
            $email = $user->email;

            Mail::to($email)->send(new MonthlyReportMail($user));
        }
    }
}
