<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Ticket;
use XSSCleaner;
use App\Language;
use Carbon\Carbon;
use App\BasicExtended as BE;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPMailer\PHPMailer\PHPMailer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class DigitalSystemController extends Controller
{
    public $digital_url     = "";

    public function __construct()
    {
        $this->digital_url  = env("DIGITAL_URL", "https://digital.angelbookhouse.com");
    }

    public function digital_ticket(Request $request, $user_id, string $key)
    {
        if(trim($key) != md5('Angel')) return abort(403);

        $user           = User::firstOrCreate([
            'is_digital_system' => true,
            'fname'             => "Digital",
            'lname'             => "Angel",
            'username'          => "Angel Digital System",
            'email'             => "digital@angel.system",
        ]);
        $user->save();

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $bs = $currentLang->basic_setting;

        $be             = BE::firstOrFail();
        $from           = $user->email;
        $to             = $be->to_mail;
        $subject        = "SYSTEM TICKET :: A clients needs approval to access digital resources";
        $message        = "There is a client who needs admin approval to access digital resources on the LMS. A copy of the submitted form was forwarded to Admin at EasyForms system on ".date("D m Y h:ia");


        ///create a ticket
        $input['subject']       = $subject;
        $input['message']       = $message;
        $input['user_id']       = $user->id;
        //$input['product_id']    = $product->id;
        $input['ticket_number'] = rand(1000000,9999999);
        $input['last_message']  = Carbon::now();
        $input['digital_system_user_id']        = $user_id;
        $input['digital_system_stack_trace']    = $request;


        //send email
        try
        {

            $mail       = new PHPMailer(true);
            $mail->setFrom($from, $user->name);
            $mail->addAddress($to);     // Add a recipient

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message." that was about ".now()->diffForHumans()." <br/> <small>ticket number <strong>#".$input['ticket_number']."</strong></small>";

            $mail->send();
        }catch (\Exception $e) { }

        $ticket                 = Ticket::firstOrCreate($input);
        $ticket->user_id        = $user->id;

        return response()->json([
            'success'   => true,
        ], Response::HTTP_OK);
    }

    public function sendTicketApprovalToDigital(string $approve, int $user_id)
    {
        try
        {
            $hash       = md5('Angel');
            $req_uri    = $this->digital_url."/api/digital-ticket-approval/$hash/$approve/$user_id";


            $response   = json_decode(file_get_contents($req_uri, false, stream_context_create(array(
                "ssl"   => array(
                    "verify_peer"       => false,
                    "verify_peer_name"  => false,
                )
            ))), true);


            return isset($response['success']) && isset($response['success']) == true ? true : false;


        }
        catch(\Exception $exception){
            return $exception->getMessage();
        }
        return false;
    }
}
