<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FaxSent extends Mailable
{
    use Queueable, SerializesModels;
    protected $status, $last_name, $gender, $first_name, $report;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public function __construct($status, $last_name, $gender, $first_name, $report)
    {
        $this->status = $status;
        $this->last_name = $last_name;
        $this->gender = $gender;
        $this->first_name = $first_name;
        $this->report = $report;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $path = public_path('uploads/'.$this->report);

        if($this->status == "failure")
        {   
            return $this->subject('Uw fax is NIET SUCCESVOL verzonden.')
            ->view('faxfailed') ->attach($path)->with([
                'last_name' => $this->last_name,
                'first_name' => $this->first_name,
                'gender'    => $this->gender
            ]);
        }
        else
        {
            return $this->subject('Uw fax is SUCCESVOL verzonden.')
            ->view('faxsent')->attach($path)
            ->with([
                'last_name' => $this->last_name,
                'first_name' => $this->first_name,
                'gender'    => $this->gender
            ]);
        }
   }
}
