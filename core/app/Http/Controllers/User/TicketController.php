<?php

namespace App\Http\Controllers\User;

use App\BasicExtra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\Conversation;
use App\Language;
use App\BasicExtended as BE;
use App\EmailTemplate as ET;

use Session;
use XSSCleaner;
use Validator;
use Auth;
use Carbon\Carbon;
use Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class TicketController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index()
    {
        $bex = BasicExtra::first();

        if ($bex->is_ticket == 0) {
            return back();
        }
        $data['tickets'] = Ticket::where('user_id',Auth::user()->id)->orderBy('id','DESC')->get();
        // dd("cloneangel ", $data);
        return view('user.tickets.index', $data);

    }

    public function create()
    {
        $bex = BasicExtra::first();

        if ($bex->is_ticket == 0) {
            return back();
        }
        return view('user.tickets.create');
    }

    public function ticketstore(Request $request)
    {

        $file = $request->file('zip_file');
        $allowedExts = array('zip');
        $rules = [
            'subject' => 'required',
            'description' => 'required',
            'email' => 'required|email',

        'zip_file' => [
            function ($attribute, $value, $fail) use ($file, $allowedExts) {

                $ext = $file->getClientOriginalExtension();
                if (!in_array($ext, $allowedExts)) {
                    return $fail("Only zip file supported");
                }
            },
            'max:5000'
        ],
        ];

        $messages = [
            'zip_file.max' => ' zip file may not be greater than 5 MB',
        ];

        $request->validate($rules, $messages);
        $input = $request->all();

        if($request->hasFile('zip_file')){
            $file = $request->file('zip_file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('assets/front/user-suppor-file/', $filename);
            $input['zip_file'] = $filename;
        }

        $message = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->description);
        $input['message'] = XSSCleaner::clean($message);
        $input['user_id'] = Auth::user()->id;
        $input['ticket_number'] = rand(1000000,9999999);
        $input['last_message'] = Carbon::now();

        $data = new Ticket;
        $data->create($input);

        $files = glob('assets/front/temp/*');
        foreach($files as $file){
            unlink($file);
        }

        // send mail to admin
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = BE::first();
        
        $ticket_received = ET::where('email_type', '=', 'ticket_received')->first();
        $ticket_number = $input['ticket_number'];
        $ticket_description = $input['description'];
        $customer_email =(auth() && auth()->user() && auth()->user()->email)?auth()->user()->email:$input['email'];

        $from = $customer_email;
        $name = (auth() && auth()->user())?auth()->user()->name:'';
        $to = $be->to_mail;
        $subject = ($ticket_received)?$ticket_received->email_subject:'New Ticket Received';
        $body = ($ticket_received)?$ticket_received->email_body:'<p>Hello,</p><p><br></p><p>Your have received a ticket: {ticket_number} from email: {customer_email} with following message as:</p><p>{ticket_description}</p><p><br></p><p>Best Regards,</p><p><br></p><p>{website_title}</p>';
        
        $body = str_replace("{ticket_number}","#".$ticket_number."","".$body."");
        $body = str_replace("{customer_email}","".$customer_email."","".$body."");
        $body = str_replace("{ticket_description}","".$ticket_description."","".$body."");
        $body = str_replace("{website_title}","".$bs->website_title."","".$body."");

        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
            try {
                $mail->isSMTP();
                $mail->Host       = $be->smtp_host;
                $mail->SMTPAuth   = true;
                $mail->Username   = $be->smtp_username;
                $mail->Password   = $be->smtp_password;
                $mail->SMTPSecure = $be->encryption;
                $mail->Port       = $be->smtp_port;

                //Recipients
                $mail->setFrom($from, $name);
                $mail->addAddress($to);
                $mail->addReplyTo($from, $name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $body;


                $mail->send();
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($customer_email);
                $mail->addAddress($to);
                $mail->addReplyTo($from, $name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $body;

                $mail->send();
            } catch (Exception $e) {

            }
        }


        Session::flash('success', 'Ticket Submitted Successfully');
        return redirect(route('user-tickets'));

    }

    public function messages($id)
    {
        $bex = BasicExtra::first();

        if ($bex->is_ticket == 0) {
            return back();
        }
        $data['ticket'] = Ticket::where('ticket_number',$id)->first();

        return view('user.tickets.messages',$data);

    }

    public function ticketreply(Request $request , $id)
    {
        dd("com");
        $file = $request->file('file');
        $allowedExts = array('zip');
        $rules = [
        'reply' => 'required',
        'file' => [
            function ($attribute, $value, $fail) use ($file, $allowedExts) {

                $ext = $file->getClientOriginalExtension();
                if (!in_array($ext, $allowedExts)) {
                    return $fail("Only zip file supported");
                }
            },
            'max:5000'
        ],
        ];

        $messages = [
            'file.max' => ' zip file may not be greater than 5 MB',
        ];

        $request->validate($rules, $messages);
        $input = $request->all();
       
        $reply = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->reply);
        $input['reply'] = XSSCleaner::clean($reply);
        $input['user_id'] = Auth::user()->id;
        $input['admin_id'] = null;
        $input['ticket_id'] = $id;
        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('assets/front/user-suppor-file/', $filename);
            $input['file'] = $filename;
        }

        $data = new Conversation;
        $data->create($input);

        $files = glob('assets/front/temp/*');
        foreach($files as $file){
            unlink($file);
        }

        Ticket::where('id',$id)->update([
            'last_message' => Carbon::now(),
        ]);

        $ticket = Ticket::findOrFail($id);
        
        // send mail to admin
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = BE::first();
        
        $message_received = ET::where('email_type', '=', 'message_received')->first();
        $ticket_number = $ticket->ticket_number;
        $message = $input['reply'];
        $customer_email =(auth() && auth()->user() && auth()->user()->email)?auth()->user()->email:'no email';
        
        $from = $customer_email;
        $name = (auth() && auth()->user())?auth()->user()->name:'';
        // $to = $be->to_mail;
        $to = "zeeshannaiz736@gmail.com";

        $subject = ($message_received)?$message_received->email_subject:'New Message Received';
        $body = ($message_received)?$message_received->email_body:'<p style="line-height: 1.6;">Hello,</p><p style="line-height: 1.6;"><br></p><p style="line-height: 1.6;">You have received new message on ticket number: {ticket_number} from email: {customer_email} with following message as:</p><p>{message}</p><p><br></p><p>Best Regards,</p><p><br></p><p>{website_title}</p>';
        
        $body = str_replace("{ticket_number}","#".$ticket_number."","".$body."");
        $body = str_replace("{customer_email}","".$customer_email."","".$body."");
        $body = str_replace("{message}","".$message."","".$body."");
        $body = str_replace("{website_title}","".$bs->website_title."","".$body."");

        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
            try {
                $mail->isSMTP();
                $mail->Host       = $be->smtp_host;
                $mail->SMTPAuth   = true;
                $mail->Username   = $be->smtp_username;
                $mail->Password   = $be->smtp_password;
                $mail->SMTPSecure = $be->encryption;
                $mail->Port       = $be->smtp_port;

                //Recipients
                $mail->setFrom($from, $name);
                $mail->addAddress($to);
                $mail->addReplyTo($from, $name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $body;


                $mail->send();
            } catch (Exception $e) {
                // die($e->getMessage());
                dd($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($customer_email);
                $mail->addAddress($to);
                $mail->addReplyTo($from, $name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $body;

                $mail->send();
            } catch (Exception $e) {

            }
        }

        Session::flash('success', 'Message Sent Successfully');
        return back();

    }


    public function zip_upload(Request $request)
    {

        $file = $request->file('file');
        $allowedExts = array('zip');
        $rules = [
        'file' => [
            function ($attribute, $value, $fail) use ($file, $allowedExts) {
                $ext = $file->getClientOriginalExtension();
                if (!in_array($ext, $allowedExts)) {
                    return $fail("Only zip file supported");
                }
            },
            'max:5000'
        ],
        ];

        $messages = [
            'file.max' => ' zip file may not be greater than 5 MB',
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
          }

        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('assets/front/temp/', $filename);
            $input['file'] = $filename;
        }

        return response()->json(['data'=>1]);

    }
}
