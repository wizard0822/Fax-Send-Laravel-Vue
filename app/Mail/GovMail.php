<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GovMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $gen_pdf, $gov_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($gov_name, $gen_pdf, $last_name)
    {
        $this->gen_pdf = $gen_pdf;
        $this->gov_name = $gov_name;
        $this->last_name = $last_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Ingebrekestelling  '.' .'.$this->last_name;
        $path = public_path('uploads/'.$this->gen_pdf);
        return $this->subject($subject)
        ->view('government')->attach($path)->with([
                'gov_name' => $this->gov_name,
            ]);    
    }
}
