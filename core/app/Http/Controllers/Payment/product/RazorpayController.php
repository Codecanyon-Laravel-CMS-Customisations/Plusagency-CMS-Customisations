<?php

namespace App\Http\Controllers\Payment\product;

use App\Http\Controllers\Payment\product\PaymentController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Razorpay\Api\Api;
use App\Language;
use App\PaymentGateway;
use App\ProductOrder;
use Illuminate\Support\Facades\Session;

use App\BasicSetting;
use App\Http\Helpers\KreativMailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PDF;

class RazorpayController extends PaymentController
{
    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('razorpay')->first();
        $paydata = $data->convertAutoData();
        $this->keyId = $paydata['key'];
        $this->keySecret = $paydata['secret'];
        $this->api = new Api($this->keyId, $this->keySecret);
    }


    public function store(Request $request)
    {
        if (!Session::has('cart')) {
            return view('errors.404');
        }


        // dd($request);

        
        $cart = Session::get('cart');

        $total = $this->orderTotal($request->shipping_charge);

        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bex = $currentLang->basic_extra;
        $be = $currentLang->basic_extended;
        $bs = $currentLang->basic_setting;
        $userCountry = app()->make('user_country');
        // dd($userCountry);
        if (!$userCountry && isset($userCountry->name) !== 'India') {
            $bex->base_currency_text = 'USD';
        }

        if ($this->orderValidation($request)) {
            return $this->orderValidation($request);
        }
        // Validation Ends


        $txnId = 'txn_' . str_random(8) . time();
        $chargeId = 'ch_' . str_random(9) . time();

        $order = $this->saveOrder($request, $txnId, $chargeId);

        $order_id = $order->id;

        $this->saveOrderedItems($order_id);

        $orderInfo['title'] = $bs->website_title . " Order";
        $orderInfo['item_number'] = str_random(4) . time();
        $orderInfo['item_amount'] = $total;
        $orderInfo['order_id'] = $order_id;
        $cancel_url = route('product.payment.cancle');
        $notify_url = route('product.razorpay.notify');


        $orderData = [
            'receipt'         => $orderInfo['title'],
            'amount'          => $orderInfo['item_amount'] * 100,
            'currency'        => ship_to_india() ? 'INR' : 'USD',
            'payment_capture' => 1 // auto capture
        ];

        $razorpayOrder = $this->api->order->create($orderData);

        Session::put('order_data', $orderInfo);
        Session::put('order_payment_id', $razorpayOrder['id']);

        $displayAmount = $amount = $orderData['amount'] / 100;

        $checkout = 'automatic';

        if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true)) {
            $checkout = $_GET['checkout'];
        }

        $data = [
            "key"               => $this->keyId,
            "amount"            => $amount,
            "name"              => $orderInfo['title'],
            "description"       => $orderInfo['title'],
            "prefill"           => [
                "name"              => $request->billing_fname,
                "email"             => $request->billing_email,
                "contact"           => $request->billing_number,
            ],
            "notes"             => [
                "address"           => $request->billing_address,
                "merchant_order_id" => $orderInfo['item_number'],
            ],
            "theme"             => [
                "color"             => "{{$bs->base_color}}"
            ],
            "order_id"          => $razorpayOrder['id'],
        ];

        if ($bex->base_currency_text !== 'INR') {
            $data['display_currency']  = $bex->base_currency_text;
            $data['display_amount']    = $displayAmount;
        }

        $json = json_encode($data);
        $displayCurrency = $bex->base_currency_text;

        return view('front.razorpay', compact('data', 'displayCurrency', 'json', 'notify_url'));
    }

    public function notify(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;

        $order_data = Session::get('order_data');
        $orderid = $order_data["order_id"];
        $success_url = route('product.payment.return');
        $cancel_url = route('product.payment.cancle');
        $input_data = $request->all();
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('order_payment_id');

        $success = true;

        if (empty($input_data['razorpay_payment_id']) === false) {

            try {
                $attributes = array(
                    'razorpay_order_id' => $payment_id,
                    'razorpay_payment_id' => $input_data['razorpay_payment_id'],
                    'razorpay_signature' => $input_data['razorpay_signature']
                );

                $this->api->utility->verifyPaymentSignature($attributes);
            } catch (SignatureVerificationError $e) {
                $success = false;
            }
        }

        if ($success === true) {

            $po = ProductOrder::findOrFail($order_data["order_id"]);
            $po->payment_status = "Completed";
            $po->save();


            // Send Mail to Buyer
            $this->sendMails($po);

            Session::forget('order_data');
            Session::forget('order_payment_id');

            return redirect($success_url);
        }
        return redirect($cancel_url);
    }



    public function sendMails($order) {
        $bs = BasicSetting::first();

        $fileName = str_random(4) . time() . '.pdf';
        $path = 'assets/front/invoices/product/' . $fileName;
        $data['order']  = $order;
        $pdf = PDF::loadView('pdf.product', $data)->save($path);


        ProductOrder::where('id', $order->id)->update([
            'invoice_number' => $fileName
        ]);

        // Send Mail to Buyer
        $mailer = new KreativMailer;
        $data = [
            'toMail' => $order->billing_email,
            'toName' => $order->billing_fname,
            'attachment' => $fileName,
            'customer_name' => $order->billing_fname,
            'order_number' => $order->order_number,
            'order_link' => !empty($order->user_id) ? "<strong>Order Details:</strong> <a href='" . route('user-orders-details',$order->id) . "'>" . route('user-orders-details',$order->id) . "</a>" : "",
            'website_title' => $bs->website_title,
            'templateType' => 'product_order',
            'type' => 'productOrder'
        ];

        $mailer->mailFromAdmin($data);

        Session::forget('cart');
        Session::forget('coupon');
    }
}
