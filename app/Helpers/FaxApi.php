<?php

namespace App\Helpers;

use App\Fax;
use App\Government;
use Illuminate\Support\Facades\Storage;

//I tried to implement the regular Laravel Standard but this library doesnt have namespaces.
include( base_path('vendor/pamfax/api/lib/apiclient.class.php') );
require_once( base_path('vendor/pamfax/api/lib/apiclient.class.php') );
require_once( base_path('vendor/pamfax/api/lib/apierror.class.php') );
require_once( base_path('vendor/pamfax/api/lib/apilist.class.php') );
require_once( base_path('vendor/pamfax/api/lib/errorcode.class.php') );
require_once( base_path('vendor/pamfax/api/static/sessionapi.class.php') );
require_once( base_path('vendor/pamfax/api/static/faxhistoryapi.class.php') );


function pamfax_use_static(){ foreach(glob(base_path('vendor/pamfax/api/static/*')) as $f) require_once($f); }
function pamfax_use_instance(){ foreach(glob(base_path('vendor/pamfax/api/instance/*')) as $f) require_once($f); }

class FaxApi
{

    /**
     * @param $faxId
     * @param $governmentId
     * @return array|bool|mixed|string
     * @throws \Exception
     */
    public static function sendFax( $faxId, $governmentId )
    {

        self::initPamFaxApi();

        $fax = Fax::find($faxId);
        $government = Government::find($governmentId);

        // verify the PamFax user (this is the same as used on https://portal.pamfax.biz etc to login):
        $result = \SessionApi::VerifyUser(env('FAX_API_USER'), env('FAX_API_PASSWORD'));

        $result = json_decode($result);

        if ( isset($result->result->type) && $result->result->type == 'error') {
            throw new \Exception($result->result->message);
        }


        if ( !isset($result->UserToken) || !isset($result->User) ) { // implicit error{
            throw new \Exception("Unable to login, implicit error");
        }

        $GLOBALS['PAMFAX_API_USERTOKEN'] = $result->UserToken->token;
        $currentUser = $result->User;

        \FaxJobApi::Create(request()->server('REMOTE_ADDR'), request()->server('HTTP_USER_AGENT'), 'RALPH FAX WEBSITE');

        $receipient = \FaxJobApi::AddRecipient("+{$government->fax}", "{$government->name}{$fax->id}");

        $receipient = json_decode($receipient);

        $recipientUuid = $receipient->FaxRecipient->uuid;

        $pdfPath = public_path('uploads/' . $fax->gen_pdf);
        \FaxJobApi::AddFile($pdfPath);

        $faxUuid = null;

        do {
            sleep(5);
            $faxState = \FaxJobApi::GetFaxState();
            $faxState = json_decode($faxState);

            if ( isset($result->result->type) && $result->result->type == 'error') {
                $fax_error = $result->result->message;
            }

        } while ( $faxState->FaxContainer->state != "ready_to_send" );

        if ( isset($fax_error) ) {
            throw new \Exception($fax_error);
        }

        \FaxJobApi::Send();


        $fax->pamfax_uuid = $recipientUuid;
        $fax->save();

        $result = true;

        return $result;
    }

    /**
     * @param $faxId
     * @return string
     * @throws \Exception
     */
    public static function polling( $faxId )
    {

        self::initPamFaxApi();
        $fax = Fax::find($faxId);

        $result = \SessionApi::VerifyUser(env('FAX_API_USER'), env('FAX_API_PASSWORD'));

        $result = json_decode($result);

        if ( isset($result->result->type) && $result->result->type == 'error') {
            throw new \Exception($result->result->message);
        }

        // set the global usertoken
        $GLOBALS['PAMFAX_API_USERTOKEN'] = $result->UserToken->token;

        $trans = \FaxHistoryApi::GetTransmissionReport($fax->pamfax_uuid);
        $reportName = "{$faxId}_TransmissionReport.pdf";
        Storage::disk('admin')->put("reports/{$reportName}", $trans);
        $fax->trans = "reports/{$reportName}";
        $fax->status = 'static-success';
        $fax->save();

        return $reportName;
    }

    /**
     * Initialize Pam Fax API
     */
    private static function initPamFaxApi()
    {
        pamfax_use_static();
        if ( !isset($_SERVER['SERVER_ADDR']) ) {
            $_SERVER['SERVER_ADDR'] = '127.0.0.1';
        }

        $GLOBALS['PAMFAX_API_URL'] = env("PAMFAX_API_URL", "https://api.pamfax.biz/");
        $GLOBALS['PAMFAX_API_APPLICATION'] = env("PAMFAX_API_APPLICATION", "RalphTjon1");
        $GLOBALS['PAMFAX_API_SECRET_WORD'] = env('PAMFAX_API_SECRET_WORD', "foxtouhooxacirity3835");
        $GLOBALS['PAMFAX_API_MODE'] = \ApiClient::API_MODE_JSON;
    }
}


//Verify User Example response
/*
{
  "result": {
    "code": "success",
    "type": "",
    "count": 4,
    "message": ""
  },
  "User": {
    "uuid": "UEygC4xUucxjTq",
    "username": "fax@burobezwaarberoep.nl",
    "created": "2016-03-29 13:13:17",
    "credit": 5.43,
    "free_credit": 1.2,
    "inactive_credit": 0,
    "reactivated_credit": 0,
    "email": "fax@burobezwaarberoep.nl",
    "confirmed": "1",
    "region": "BIZ",
    "is_member": 0,
    "cm_availible": 0,
    "name": "Buro Bezwaar en Beroep"
  },
  "Currency": {
    "code": "EUR",
    "raw_symbol": "€"
  },
  "UserToken": {
    "token": "ffecac6cd958a513b62abbe083c768d9"
  },
  "UserRights": {
    "type": "list",
    "content": [
      {
        "name": "see_credit",
        "allowed": 1
      },
      {
        "name": "buy_credit",
        "allowed": 1
      },
      {
        "name": "buy_number",
        "allowed": 1
      },
      {
        "name": "transfer_credit",
        "allowed": 1
      },
      {
        "name": "receive_messages",
        "allowed": 1
      }
    ]
  }
}
*/
