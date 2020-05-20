<?php

namespace App\Console\Commands;

use App\ScheduledEmails;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminSummaryEmail;

class SendSummaryEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send summary emails to the people who have requested them.';

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
     * @return mixed
     */
    public function handle()
    {
        $peopleToEmail = ScheduledEmails::all();

        //Cycle through users who want emails
        foreach ($peopleToEmail as $emailToSend) {

            //Check if the needed time interval has passed
            if($emailToSend->timeToSendAgain()){
                $address = $emailToSend->getUserEmail();

                //For each person who wants to be emailed, send them an email if it is time
                Mail::to($address)->send(new AdminSummaryEmail($address));

                //If sent successfully, update the last sent time
                $emailToSend->last_sent = Carbon::now();
                $emailToSend->save();
            }
        }

        return "Sent emails.";
    }
}
