<?php

namespace App\Http\Controllers\Admin\Currency;


use App\Models\Country;
use App\Http\Controllers\Controller;

class CountriesController extends Controller
{
    public function index() {
        $countries  = Country::all();
        return view('admin.currency.countries.index',
        compact('countries'));
    }
}
