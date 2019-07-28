<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Fax;
use App\Customer;
use App\Mail\FaxSent;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $fax_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fax_id)
    {
        $this->fax_id = $fax_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fax = Fax::FindOrFail($this->fax_id);
        $mail = $fax->customer->email;
        $status = $fax->status;
        $first_name = $fax->customer->first_name;
        $last_name = $fax->customer->last_name;
        $gender = $fax->customer->gender;
        $report = $fax->new_trans;

        \Mail::to($mail)->send(new FaxSent($status, $last_name, $gender, $first_name, $report));
    }
}
