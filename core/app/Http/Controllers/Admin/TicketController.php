<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ticket;
use Validator;
use Auth;
use XSSCleaner;
use App\Conversation;
use Session;
use App\Admin;
use App\User;
use App\BasicExtra;
use App\Http\Controllers\API\DigitalSystemController;
use App\Language;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use App\EmailTemplate as ET;
use App\ProductTicket as PT;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use DB;

class TicketController extends Controller
{
    public function all(Request $request) {
        $search = $request->search;
        if(Auth::guard('admin')->user()->id == 1){
        $tickets = Ticket::orderby('last_message','DESC')
        ->when($search, function ($query, $search) {
            return $query->where('ticket_number', $search);
        })
        ->when($search, function ($query, $search) {
            return $query->orwhere('subject', 'like', '%' . $search . '%');
        })
        ->paginate(10);
        }else{
            $tickets = Ticket::where('admin_id',Auth::guard('admin')->user()->id)
            ->when($search, function ($query, $search) {
                return $query->where('ticket_number', $search);
            })
            ->when($search, function ($query, $search) {
                return $query->orwhere('subject', 'like', '%' . $search . '%');
            })
            ->orderby('last_message','DESC')->paginate(10);
        }
        return view('admin.tickets.index',compact('tickets'));
    }

    public function pending(Request $request) {
        $search = $request->search;
        if(Auth::guard('admin')->user()->id == 1){
            $tickets = Ticket::where('status','pending')
            ->when($search, function ($query, $search) {
                return $query->where('ticket_number', $search);
            })
            ->when($search, function ($query, $search) {
                return $query->orwhere('subject', 'like', '%' . $search . '%');
            })
            ->orderby('id','desc')->paginate(10);
        }else{
            $tickets = Ticket::where('status','pending')
            ->when($search, function ($query, $search) {
                return $query->where('ticket_number', $search);
            })
            ->when($search, function ($query, $search) {
                return $query->orwhere('subject', 'like', '%' . $search . '%');
            })
            ->where('admin_id',Auth::guard('admin')->user()->id)->orderby('id','desc')->paginate(10);
        }
       return view('admin.tickets.index',compact('tickets'));
    }

    public function open(Request $request) {
        $search = $request->search;
        if(Auth::guard('admin')->user()->id == 1){
            $tickets = Ticket::where('status','open')
            ->when($search, function ($query, $search) {
                return $query->where('ticket_number', $search);
            })
            ->when($search, function ($query, $search) {
                return $query->orwhere('subject', 'like', '%' . $search . '%');
            })
            ->orderby('last_message','DESC')->paginate(10);
            }else{
                $tickets = Ticket::where('admin_id',Auth::guard('admin')->user()->id)
                ->when($search, function ($query, $search) {
                    return $query->where('ticket_number', $search);
                })
                ->when($search, function ($query, $search) {
                    return $query->orwhere('subject', 'like', '%' . $search . '%');
                })
                ->where('status','open')->orderby('last_message','DESC')
                ->paginate(10);
            }
       return view('admin.tickets.index',compact('tickets'));
    }

    public function closed(Request $request) {
        $search = $request->search;
       if(Auth::guard('admin')->user()->id == 1){
        $tickets = Ticket::where('status','close')
        ->when($search, function ($query, $search) {
            return $query->where('ticket_number', $search);
        })
        ->when($search, function ($query, $search) {
            return $query->orwhere('subject', 'like', '%' . $search . '%');
        })
        ->orderby('last_message','desc')->paginate(10);
       }else{
        $tickets = Ticket::where('status','close')
        ->when($search, function ($query, $search) {
            return $query->where('ticket_number', $search);
        })
        ->when($search, function ($query, $search) {
            return $query->orwhere('subject', 'like', '%' . $search . '%');
        })
        ->where('admin_id',Auth::guard('admin')->user()->id)->orderby('last_message','desc')->paginate(10);
       }

       return view('admin.tickets.index',compact('tickets'));
    }

    public function messages($id) {

        $ticket = Ticket::findOrFail($id);
        return view('admin.tickets.messages',compact('ticket'));
    }

    public function zip_file_upload(Request $request)
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


    public function ticketReply( Request $request , $id)
    {

        $file = $request->file('file');

        $rules = [
        'reply' => 'required',
        ];

        $ticket = Ticket::findOrFail($id);
        $request->validate($rules);
        $input = $request->all();

        $reply = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->reply);
        $input['reply'] = XSSCleaner::clean($reply);
        $input['user_id'] = null;
        $input['admin_id'] = Auth::guard('admin')->user()->id;
        $input['ticket_id'] = $ticket->id;
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
            'status' => 'open',
        ]);


        // send mail to admin
        $ticket = Ticket::findOrFail($id);

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
        $customer_email =($ticket && $ticket->user_id)?User::where('id','=',$ticket->user_id)->first()->email:'no email';

        if ($customer_email == 'no email') {
            $customer_email = DB::table('product_ticket')->where("ticket_id",'=',$id)->first()->email;
        }


        $from = $be->to_mail;
        $name = (auth() && auth()->user())?auth()->user()->name:'';
        $to = $customer_email;
        $subject = ($message_received)?$message_received->email_subject:'New Message Received';
        $body = ($message_received)?$message_received->email_body:'<p style="line-height: 1.6;">Hello,</p><p style="line-height: 1.6;"><br></p><p style="line-height: 1.6;">You have received new message on ticket number: {ticket_number} from email: {email} with following message as:</p><p>{message}</p><p><br></p><p>Best Regards,</p><p><br></p><p>{website_title}</p>';
        
        $body = str_replace("{ticket_number}","#".$ticket_number."","".$body."");
        $body = str_replace("{email}","".$from."","".$body."");
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

        Session::flash('success', 'message send successfully');
        return back();
    }

    public function ticketclose($id)
    {
        return $id;

        Ticket::where('id',$id)->update([
            'status' => 'close',
        ]);
        Session::flash('success', 'ticket close successfully.');
        return 'success';
    }

    public function ticket_digital_approval($id, $verdict)
    {
        //send verdict to digital
        $ticket     = Ticket::findOrFail($id);
        $client     = $ticket->digital_system_user_id;

        if(!is_int($client) || intval($client) < 1) return abort(404);

        $approve    = $verdict == "approve" ? md5("true") : md5("false");
        $response   = (new DigitalSystemController())
        ->sendTicketApprovalToDigital($approve, $client);

        if($response)
        {
            if($verdict == "approve")
            {
                session()->flash('success', 'Client Account Approved successfully');
                $ticket->status = 'close';$ticket->save(); return 'success';
            }
            else
            {
                session()->flash('success', 'Client Account Revoked successfully');
                $ticket->status = 'close';$ticket->save(); return 'success';
            }
        }
        else
        {
            if($verdict == "approve")
            {
                session()->flash('error', 'Error Approving Client Account');
                return 'error';
            }
            else
            {
                session()->flash('error', 'Error Revoking Client Account');
                return 'error';
            }
        }



        // Ticket::where('id',$id)->update([
        //     'status' => 'close',
        // ]);
        Session::flash('success', 'ticket close successfully.');
        return 'success';
    }




    public function ticketAssign(Request $request)
    {
        $rules = [
            'staff' => 'required',
            ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $admin = Admin::findOrFail($request->staff)->username;
       Ticket::where('id',$request->ticket_id)->update([
        'admin_id' => $request->staff
       ]);
       Session::flash('success', 'ticket assign to '.$admin);
       return 'success';

    }

    public function settings() {
        $data['abex'] = BasicExtra::first();
        return view('admin.tickets.settings', $data);
    }

    public function updateSettings(Request $request) {
        $bexs = BasicExtra::all();
        foreach($bexs as $bex) {
            $bex->is_ticket = $request->is_ticket;
            $bex->save();
        }

        $request->session()->flash('success', 'Settings updated successfully!');
        return back();
    }
}
