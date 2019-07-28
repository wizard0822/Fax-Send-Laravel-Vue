<?php

namespace App\Http\Controllers;

use App\Fax;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function webhook(Request $request)
    {
        // guard
        if (!$data = $request->get('letter')) {
            return abort(403, 'data is incorrupt');
        }
        // guard
        if (!$fax = Fax::where(['type_id' => 2, 'postbode_id' => $data['id']])->whereNotNull('postbode_id')->first()) {
            return abort(403, 'could not find postbode_id in our database');
        }

        // set status
        $fax->postbode_status = $data['status'];

        // save
        $fax->save();

        // if satus is send, send our mails
        if ($fax->postbode_status == 'send') {

            // send email
            SendEmailJob::dispatch($fax->id);
        }

        return 'done';
    }
}

// example response
// {
//   "letter": {
//     "id": 198323,
//     "mailbox_id": 1,
//     "envelope_id": 2,
//     "shipping_method_id": 23,
//     "service": "send",
//     "status": "concept",
//     "color": "full color",
//     "printing": "simplex",
//     "paper_weight": "80g",
//     "paper_size": "A4",
//     "tracking_code": null,
//     "formatted_id": "PB10198323",
//     "shipping_id": 23,
//     "weight": 18,
//     "pages": 2,
//     "sheets": 2
//   }
// }