<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\DatabaseHelper;
use App\Links;
use Illuminate\Support\Facades\DB;

class AdminSummaryEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailToAddress)
    {
        $this->emailToAddress = $emailToAddress;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pendingCount = DatabaseHelper::getCountOfAllPendingSubmissions();
        $brokenLinkCount = DB::table('links')->where('status', "broken")->count();
        $approvedCount = DatabaseHelper::getCountOfAllApprovedSubmissions();

        return $this->from('no-reply@waterreuseapp.org')->subject("Water Reuse App Summary")
            ->view('email.summaryEmail')->with([
                'pendingCount' => $pendingCount,
                'brokenLinkCount' => $brokenLinkCount,
                'approvedCount' => $approvedCount,
                'emailToAddress' => $this->emailToAddress
            ]);
    }
}
