<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Fax;
use App\Government;
use App\Helpers\Postal;
use App\Jobs\SendFax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Session;
use App\Helpers\PdfGenerator;
use App\Mail\FaxSent;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class FaxController extends Controller
{

    public function index()
    {
        return view('index');
    }

    public function thanks()
    {

        return view('thank');
    }

    public function upload()
    {
        if ( !Session::has('first_name') ) {
            return redirect('../');
        } else
            return Response::view('upload')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_postal' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'home_num' => 'required',
            'customer_email' => 'required',
            'customer_address' => 'required',
            'customer_city' => 'required',
            'bank_account' => 'required',
            'name' => 'required',
            'department' => 'required',
            'email' => 'required',
            'fax' => 'required',
            'address' => 'required',
            'postal' => 'required',
            'city' => 'required',
            'date' => 'required',
            'letter_received' => 'required',
            'applied_for' => 'required',
        ]);

        $fax_number = $request->fax;
        if (strlen($fax_number) == 10) {
            $fax_number = substr($fax_number, 1);
            $fax_number = "31" . $fax_number;
        }

        Session::put([
            'customer_postal' => $request->customer_postal,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'home_num' => $request->home_num,
            'customer_email' => $request->customer_email,
            'customer_address' => $request->customer_address,
            'customer_city' => $request->customer_city,
            'notes' => $request->notes,
            'bank_account' => $request->bank_account,
            'name' => $request->name,
            'department' => $request->department,
            'email' => $request->email,
            'fax' => $fax_number,
            'address' => $request->address,
            'postal' => $request->postal,
            'city' => $request->city,
            'date' => $request->date,
            'letter_received' => $request->letter_received,
            'applied_for' => $request->applied_for,
        ]);

        return redirect('../upload');
    }

    public function signature( Request $request )
    {
        ini_set('memory_limit', '256M');
        $sigPresent = 0;
        $customer = new Customer();
        if ( $request->has('jsignature') && $request->filled('jsignature') ) {

            $jsignature = $request['jsignature'];
            $signature = base64_decode(str_replace("data:image/png;base64,", "", $jsignature));
            //gemerate signature file.
            $sign_file = (string) rand(1, 1000000) . ".png";
            //create it.
            Storage::disk('admin')->put($sign_file, $signature);
            session()->put([ 'customer_sign' => $sign_file ]);
            $customer->sign = session('customer_sign');
            $sigPresent = 1;
        }

        if ( $request->has('imgName') && $request->has('imgPath') ) {
            $customer->sign_name = $request['imgName'];
            $customer->sign_path = $request['imgPath'];
            if ( $sigPresent == 0 ) {
                $customer->sign_image = 1;
            }
        }

        $customer->first_name = session('first_name');
        $customer->last_name = session('last_name');
        $customer->gender = session('gender');
        //post
        $customer->postal = session('customer_postal');
        //home
        $customer->home_num = session('home_num');
        $customer->phone = session('phone');
        $customer->email = session('customer_email');
        $customer->address = session('customer_address');
        $customer->city = session('customer_city');
        $customer->notes = session('notes');
        $customer->bank_account = session('bank_account');

        $customer->save();

        $government = new Government();
        $government->name = session('name');
        $government->department = session('department');
        $government->email = session('email');
        $government->fax = session('fax');
        $government->address = session('address');
        $government->postal = session('postal');
        $government->city = session('city');
        $government->save();

        // create new fax
        $fax = new Fax();
        $fax->date = session('date');
        $fax->letter_received = session('letter_received');
        $fax->applied_for = session('applied_for');
        $fax->government_id = $government->id;
        $fax->customer_id = $customer->id;

        // set fax type
        if ( $government->fax == "Geen faxnummer bekend" ) {

            // set letter
            $fax->type_id = 2;
        } else {

            // set fax
            $fax->type_id = 1;
        }

        // save the fax
        $fax->save();

        $gen_faxcode = "IGB" . (string) $fax->id;
        $fax->gen_faxcode = $gen_faxcode;

        $fax->Save();

        session()->put([
            'gen_faxcode' => $gen_faxcode,
            'fax_id'      => $fax->id,
        ]);

        SendFax::dispatch($fax->id, $government->id, $customer->id, $customer->email);

        PdfGenerator::generate($fax->id, $government->id, $customer->id);

        return redirect('../thanks');
    }

    public function ValidatePostal( Request $request )
    {
        return Postal::Validate($request);

    }

    public function Polling()
    {
        $fax = Fax::FindOrFail(250);
        $mail = $fax->customer->email;
        $status = $fax->status;
        $first_name = $fax->customer->first_name;
        $last_name = $fax->customer->last_name;
        $gender = $fax->customer->gender;
        $report = $fax->new_trans;

        \Mail::to($mail)->send(new FaxSent($status, $last_name, $gender, $first_name, $report));
    }


    public function processImage( Request $request )
    {

        if ( $file = $request->file('dzfile') ) {

            ini_set('memory_limit', '256M');

            $this->validate($request, [
                'dzfile' => 'required|mimes:jpeg,jpg,png|max:2000',
            ]);

            $name = time() . $file->getClientOriginalName();
            $path = public_path() . '/assets/signatures/' . $name;
            $file->move('assets/signatures/', $name);
            $img = Image::make($path)->greyscale()->contrast(50)->brightness(40);
            $img->save($path);
            $rt = new \stdClass();
            $rt->name = $name;
            $rt->path = $path;
            $rt->url = 'https://fax.beslisapp.nl/assets/signatures/' . $name;

            return response()->json($rt);
        } else {
            return "File Not Found";
        }
    }








    public function getGeneral()
    {
        $municipalities = DB::table('municipality')->get();
        return response()->json([
            'app_type' => Session::get('app_type'),
            'app_data' => Session::get('app_data'),
            'request_date' => Session::get('request_date'),
            'letter_received' => Session::get('letter_received'),
            'subject' => Session::get('subject'),
            'municipality' => Session::get('municipality'),
            'municipalities' => compact('municipalities'),
        ]);
    }

    public function saveGeneral(Request $request)
    {
        Session::put([
            'app_type' => $request->app_type,
            'app_data' => $request->app_data,
            'request_date' => $request->request_date,
            'letter_received' => $request->letter_received,
            'subject' => $request->subject,
            'feature' => $request->feature,
            'municipality' => $request->municipality,
        ]);
        return response()->json([
            "result" => "success",
            "message" => "Saved successfully"
        ]);
    }
    
    public function getClient()
    {
        return response()->json([
            'gender' => Session::get('gender'),
            'firstname' => Session::get('firstname'),
            'lastname' => Session::get('lastname'),
            'postcode' => Session::get('postcode'),
            'housenumber' => Session::get('housenumber'),
            'telephone' => Session::get('telephone'),
            'banknumber' => Session::get('banknumber'),
            'email' => Session::get('email'),
            'address' => Session::get('address'),
            'city' => Session::get('city'),
        ]);
    }

    public function saveClient(Request $request)
    {
        Session::put([
            'gender' => $request->gender,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'postcode' => $request->postcode,
            'housenumber' => $request->housenumber,
            'telephone' => $request->telephone,
            'banknumber' => $request->banknumber,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
        ]);

        return response()->json([
            "result" => "success",
            "message" => "Saved successfully"
        ]);
    }

    public function publish(Request $request)
    {
        if(Session::get('app_type') == '' || Session::get('gender') == '' ){
            return response()->json([
                "result" => "fail",
                "message" => "You need to fill all information"
            ]);
        }
        // Session::forget('app_data');
        // Session::forget('request_date');
        // Session::forget('letter_received');
        // Session::forget('subject');
        // Session::forget('feature');
        // Session::forget('municipality');
        // Session::forget('gender');
        // Session::forget('firstname');
        // Session::forget('lastname');
        // Session::forget('postcode');
        // Session::forget('housenumber');
        // Session::forget('telephone');
        // Session::forget('banknumber');
        // Session::forget('email');
        // Session::forget('address');
        // Session::forget('city');
        // ini_set('memory_limit', '256M');
        $sigPresent = 0;
        $customer = new Customer();
        if($request->mode == 1){
            if ( $request->has('sign') && $request->filled('sign') ) {
                $jsignature = $request['sign'];
                $signature = base64_decode(str_replace("data:image/png;base64,", "", $jsignature));
                $sign_file = (string) rand(1, 1000000) . ".png";
                Storage::disk('admin')->put($sign_file, $signature);
                session()->put([ 'customer_sign' => $sign_file ]);
                $customer->sign = session('customer_sign');
                $sigPresent = 1;
            }
        } else if($request->mode == 2){
            if ( $file = $request->file('media') ) {
                // var_dump("expression");
                // exit;
                $extension = $file->getClientOriginalExtension();
                $name = time() . $file->getClientOriginalName();
                $path = public_path() . '/assets/signatures/' . $name;
                $file->move('assets/signatures/', $name);
                $img = Image::make($path)->greyscale()->contrast(50)->brightness(40);
                $img->save($path);
                $rt = new \stdClass();
                $rt->name = $name;
                $rt->path = $path;
                $rt->url = 'https://fax.beslisapp.nl/assets/signatures/' . $name;

                // $customer->sign_name = $request['imgName'];
                // $customer->sign_path = $request['imgPath'];
                $customer->sign_name = $name;
                $customer->sign_path = $path;
                if ( $sigPresent == 0 ) {
                    $customer->sign_image = 1;
                }
            }
        }
        $customer->first_name = session('firstname');
        $customer->last_name = session('lastname');
        $customer->gender = session('gender');
        $customer->postal = session('postcode');
        $customer->home_num = session('housenumber');
        $customer->phone = session('telephone');
        $customer->email = session('email');
        $customer->address = session('address');
        $customer->city = session('city');
        $customer->notes = session('notes');
        $customer->bank_account = session('banknumber');

        $customer->save();

        $government = new Government();
        if(Session::has('municipality'))
        {
            $municipality = DB::table('municipality')->where('name', Session::get('municipality'))->first();
            $address = $municipality->address;
            $email = $municipality->email;
            $postal = $municipality->postal;
            $city = $municipality->city;
            $department = $municipality->department;
        
            $fax_number = $municipality->faxnumber;
            if (strlen($fax_number) == 10) {
                $fax_number = substr($fax_number, 1);
                $fax_number = "31" . $fax_number;
            }
            $government->name = $municipality->name;
            $government->department = "Burgemeester en wethouders";
            $government->email = $municipality->email;
            $government->fax = $fax_number;
            $government->address = $municipality->address;
            $government->postal = $municipality->postal;
            $government->city = $municipality->city;
            $government->save();
        }

        $fax = new Fax();
        $fax->date = session('request_date');
        $fax->letter_received = session('letter_received');
        $fax->applied_for = session('app_type');
        $fax->government_id = $government->id;
        $fax->customer_id = $customer->id;

        // set fax type
        if ( $government->fax == "Geen faxnummer bekend" ) {
            // set letter
            $fax->type_id = 2;
        } else {
            // set fax
            $fax->type_id = 1;
        }
        $fax->save();

        $gen_faxcode = "IGB" . (string) $fax->id;
        $fax->gen_faxcode = $gen_faxcode;

        $fax->Save();

        session()->put([
            'gen_faxcode' => $gen_faxcode,
            'fax_id'      => $fax->id,
        ]);

        SendFax::dispatch($fax->id, $government->id, $customer->id, $customer->email);

        PdfGenerator::generate($fax->id, $government->id, $customer->id);

        // clear all session
        Session::forget('app_type');
        Session::forget('app_data');
        Session::forget('request_date');
        Session::forget('letter_received');
        Session::forget('subject');
        Session::forget('feature');
        Session::forget('municipality');
        Session::forget('gender');
        Session::forget('firstname');
        Session::forget('lastname');
        Session::forget('postcode');
        Session::forget('housenumber');
        Session::forget('telephone');
        Session::forget('banknumber');
        Session::forget('email');
        Session::forget('address');
        Session::forget('city');

        return response()->json([
            "result" => "success",
            "message" => "custommer Saved successfully"
        ]);
    }

    public function testFunc(){
        $var = 5;
        return view('test', [
            'var' => $var
        ]);
    }

    public function uploadSign(Request $request){
        if ( $file = $request->file('media') ) {
            $extension = $file->getClientOriginalExtension();
            $name = time() . $file->getClientOriginalName();
            $path = public_path() . '/assets/signatures/' . $name;
            $file->move('assets/signatures/', $name);
            $img = Image::make($path)->greyscale()->contrast(50)->brightness(40);
            $img->save($path);
            $rt = new \stdClass();
            $rt->name = $name;
            $rt->path = $path;
            $rt->url = 'https://fax.beslisapp.nl/assets/signatures/' . $name;
            return response()->json($rt);
        }
    }
}
