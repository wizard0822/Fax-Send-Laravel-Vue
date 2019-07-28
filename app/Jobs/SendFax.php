<?php

namespace App\Jobs;

use App\Fax;
use App\Government;
use App\Helpers\FaxApi;
use App\Helpers\PdfGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Helpers\PostBode;

class SendFax implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $faxId;
    protected $governmentId;
    protected $customerId;
    protected $customerEmail;

    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @param $faxId
     * @param $governmentId
     * @param $customerId
     * @param $customerEmail
     */
    public function __construct( $faxId, $governmentId, $customerId, $customerEmail )
    {
        $this->customerId = $customerId;
        $this->governmentId = $governmentId;
        $this->faxId = $faxId;
        $this->customerEmail = $customerEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        PdfGenerator::generate($this->faxId, $this->governmentId, $this->customerId);
        $fax = Fax::findOrFail($this->faxId);
        $first_name = $fax->customer->first_name;
        $last_name = $fax->customer->last_name;
        $gender = $fax->customer->gender;
        $gen_pdf = $fax->gen_pdf;
        $gov = Government::findOrFail($this->governmentId);

        // if the fax is of type fax
        if ($fax->type_id == 1) {

            //If may or may not throw an exception
            FaxApi::sendFax($this->faxId, $this->governmentId);
            DownReport::dispatch($this->faxId)->delay(now()->addMinutes(1));

        // if the fax is of type letter
        } else {

            $fax_pdf = $fax->gen_pdf;
            $file = Storage::disk('admin')->get($fax_pdf);
            $content = base64_encode($file);

            // send the letter and receive output
            $postbode_output = PostBode::SendLetter($fax_pdf, $content);

            // update record
            $fax->postbode_id = $postbode_output->id;
            $fax->postbode_status = $postbode_output->status;

            // save
            $fax->save();
        }

        try {
            SendEmailAfterFax::dispatch($this->customerEmail, $first_name, $last_name, $gender, $gen_pdf, $gov->name, $gov->email);
        } catch ( \Exception $exception ) {
            logger('Trying to send emails', [ $exception->getMessage() ]);
        }

    }
}
