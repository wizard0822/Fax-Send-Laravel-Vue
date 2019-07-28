<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Helpers\FaxApi;
use App\Helpers\FpdiHandler;
use App\Fax;
use App\Customer;
use App\Mail\FaxSent;

class DownReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $faxId;

    /**
     * Create a new job instance.
     *
     * @param $faxId
     */
    public function __construct( $faxId )
    {
        $this->faxId = $faxId;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $report = FaxApi::polling($this->faxId);
        FpdiHandler::EditReport($report, $this->faxId);
        SendEmailJob::dispatch($this->faxId);
    }
}
