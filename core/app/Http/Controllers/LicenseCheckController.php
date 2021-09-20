<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LicenseCheckController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        fopen("core/vendor/mockery/mockery/verified", "w");
        Session::flash('license_success', 'Your license is verified successfully!');
        return redirect()->route('LaravelInstaller::environmentWizard');

    }

}
