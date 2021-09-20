<?php

namespace RachidLaasri\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class LicenseController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Display the permissions check page.
     *
     * @return \Illuminate\View\View
     */
    public function license()
    {
        return view('vendor.installer.license');
    }

    public function licenseCheck(Request $request) {
        $request->validate([
            'email' => 'required',
            'username' => 'required',
            'purchase_code' => 'required'
        ]);

        $itemid = 24646161;
        $itemname = 'PlusAgency';
        $emailCollectorApi = 'https://kreativdev.com/emailcollector/api/collect';

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://api.envato.com/v3/market/author/sale?code='.$request->purchase_code, [
                'headers' => [
                    'content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer d3eCIKWsFeVT1hoMjY7wtZlZMn0tgEO9'
                ]
            ]);

            $responseBody = $response->getBody()->getContents();
            $formattedRes = json_decode($responseBody, true);

            $buyerUsername = $formattedRes['buyer'];


            if ($request->username != $buyerUsername || $itemid != $formattedRes['item']['id']) {
                Session::flash('license_error', 'Username / Purchase code didn\'t match for this item!');
                return redirect()->back();
            }

            fopen("core/vendor/mockery/mockery/verified", "w");


            // return $request;
            // collect Email
            $response1 = $client->request('POST', $emailCollectorApi, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => [
                    'item_name' => $itemname,
                    'email' => $request->email,
                    'username' => $request->username,
                    'item_id' => $itemid,
                    'collector_key' => 'rakoombaa'
                ]
            ]);

            // dd($response1->getBody()->getContents());

            Session::flash('license_success', 'Your license is verified successfully!');
            return redirect()->route('LaravelInstaller::environmentWizard');
        } catch (\Exception $e) {
            Session::flash('license_error', "Your purchase code is not correct or Your server is missing some extension, in that case please create a support ticket here https://kreativdev.freshdesk.com/");
            return redirect()->back();
        }

    }
}
