<?php

namespace App\Http\Controllers\Admin\Currency;


use App\Models\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    public function index() {
        $currencies = Currency::all();
        return view('admin.currency.currencies.index',
        compact('currencies'));
    }

    public function toggle_activate(Currency $currency, Request $request)
    {
        if($currency->status)
        {
            //deactivate
            $currency->status   = 0;
            $currency->save();

            session()->flash('success', 'currency deactivated successfully');
            return redirect()->back();
        }

        //activate
        $currency->status       = 1;
        $currency->save();

        session()->flash('success', 'currency activated successfully');
        return redirect()->back();
    }

    public function edit(Currency $currency)
    {
        return view('admin.currency.currencies.edit', compact('currency'));
    }

    public function update(Request $request)
    {
        $currency                   = Currency::find($request->currency_id);
        $currency->name             = trim($request->name);
        $currency->acronym          = trim($request->acronym);
        $currency->symbol           = trim($request->symbol);
        $currency->symbol_position  = trim($request->symbol_position);
        $currency->text_position    = trim($request->text_position);
        $currency->status           = trim($request->status);
        $currency->save();

        session()->flash('success', 'currency updated successfully');
        return "success";
    }

    public function delete(Request $request)
    {
        $currency               = Currency::find($request->currency_id);

        if($currency->delete())
        {
            //delete
            session()->flash('success', 'currency deleted successfully');
            return redirect()->back();
        }

        //error
        session()->flash('error', 'error deleting currency');
        return redirect()->back();
    }
}
