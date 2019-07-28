<?php

namespace App\Jobs;

use App\Mail\GovMail;
use App\Mail\Thanks;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailAfterFax implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $customerEmail;
    private $firstName;
    private $lastName;
    private $gender;
    private $genPdf;
    private $govName;
    private $govEmail;

    /**
     * Create a new job instance.
     *
     * @param $customerEmail
     * @param $firstName
     * @param $lastName
     * @param $gender
     * @param $genPdf
     * @param $govName
     * @param $govEmail
     */
    public function __construct($customerEmail, $firstName, $lastName, $gender, $genPdf, $govName, $govEmail)
    {
        $this->customerEmail = $customerEmail;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->genPdf = $genPdf;
        $this->govName = $govName;
        $this->govEmail = $govEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Send emails only if everything is OK
        \Mail::to($this->customerEmail)->send(new Thanks($this->firstName, $this->lastName, $this->gender, $this->genPdf));
        \Mail::to("fax@burobezwaarberoep.nl")->send(new Thanks($this->firstName, $this->lastName, $this->gender, $this->genPdf));
        \Mail::to($this->govEmail)->send(new GovMail($this->govName, $this->genPdf, $this->lastName));
    }
}
