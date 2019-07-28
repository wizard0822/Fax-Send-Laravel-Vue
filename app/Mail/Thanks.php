<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Fax;

class Thanks extends Mailable
{
    use Queueable, SerializesModels;
    protected $gen_pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($first_name, $last_name, $gender, $gen_pdf)
    {
        $this->gen_pdf = $gen_pdf;
        $this->last_name = $last_name;
        $this->gender = $gender;
        $this->first_name = $first_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $path = public_path('uploads/'.$this->gen_pdf);
        return $this->subject('De brief is nu onderweg naar de gemeente!')
        ->view('thankyou')->attach($path)->with([
                'last_name' => $this->last_name,
                'first_name' => $this->first_name,
                'gender'    => $this->gender
            ]);    
    }
}
