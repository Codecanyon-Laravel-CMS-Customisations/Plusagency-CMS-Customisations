<?php

namespace App\Http\Controllers\Admin\Currency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting as BS;
use App\Models\Country;
use Validator;
use Session;

class CountriesController extends Controller
{
    public function index() {
        $countries  = Country::all();
        return view('admin.currency.countries.index',
        compact('countries'));
    }
}
