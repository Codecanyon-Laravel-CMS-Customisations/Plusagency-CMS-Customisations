<?php

namespace App\Http\Controllers\Admin\Currency;


use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\CurrencyConversion;
use App\Http\Controllers\Controller;
use App\Models\Country;

class CurrenciesController extends Controller
{
    public function index() {
        $currencies = Currency::all();
        return view('admin.currency.currencies.index',
        compact('currencies'));
    }
    public function conversions_index() {
        $currencies             = Currency::all()->sortBy('name', 0, false);
        $currency_conversions   = CurrencyConversion::all()->sortBy('name', 0, false);
        return view('admin.currency.conversions.index',
        compact('currencies', 'currency_conversions'));
    }
    public function world_currencies_index() {
        $world_currencies       = Country::with('currencies')->whereHas('currencies')->get()->sortBy('name', 0, false);
        $countries              = Country::all()->sortBy('name', 0, false);
        $currencies             = Currency::all()->sortBy('name', 0, false);

        // return $world_currencies;

        return view('admin.currency.world-currencies.index',
        compact('currencies', 'world_currencies', 'countries'));
    }

    public function conversions_store(Request $request) {
        $base_currency          = Currency::firstOrCreate([
            'acronym'           => 'USD'
        ]);
        $currency_conversion        = CurrencyConversion::firstOrCreate([
            'base_currency_id'      => trim($base_currency->id),
            'converted_currency_id' => trim($request->conversion_currency_id),
        ]);
        $currency_conversion->rate  = (double)trim($request->conversion_rate);
        $currency_conversion->status                = intval($request->status);
        $currency_conversion->base_currency_id      = trim($base_currency->id);
        $currency_conversion->converted_currency_id = trim($request->conversion_currency_id);
        $currency_conversion->save();

        session()->flash('success', 'Currency conversion created successfully');
        return 'success';
    }
    public function world_currencies_store(Request $request) {
        $world_currency             = Country::firstOrCreate([
            'id'                    => intval($request->country),
        ]);
        $world_currency->status     = boolval(request('status'));
        $world_currency->save();

        $pivot                    = [];

        foreach ($request->currencies as $currency_id) {
            //collect all the ids
            $pivot[$currency_id] = ['status' => (boolval(request('status')))];
        }
        $world_currency->currencies()->sync($pivot);
        // $world_currency->save();

        session()->flash('success', 'World Currency created successfully');
        return 'success';
    }

    public function conversions_update(Request $request) {
        $base_currency          = Currency::firstOrCreate([
            'acronym'           => 'USD'
        ]);
        $currency_conversion        = CurrencyConversion::firstOrCreate([
            'base_currency_id'      => trim($base_currency->id),
            'converted_currency_id' => trim($request->conversion_currency_id),
        ]);

        $currency_conversion->rate                  = (double)trim($request->conversion_rate);
        $currency_conversion->status                = intval($request->status);
        $currency_conversion->base_currency_id      = trim($base_currency->id);
        $currency_conversion->converted_currency_id = trim($request->conversion_currency_id);
        $currency_conversion->save();

        session()->flash('success', 'currency conversion updated successfully');
        return $request->expectsJson() ? 'success' : redirect()->back();
    }
    public function world_currencies_update(Request $request) {
        $world_currency             = Country::firstOrCreate([
            'id'                    => intval($request->country),
        ]);
        $world_currency->status     = boolval(request('status'));
        $world_currency->save();

        $pivot                    = [];

        foreach ($request->currencies as $currency_id) {
            //collect all the ids
            $pivot[$currency_id] = ['status' => (boolval(request('status')))];
        }
        $world_currency->currencies()->sync($pivot);
        // $world_currency->save();

        session()->flash('success', 'World Currency updated successfully');
        return $request->expectsJson() ? 'success' : redirect()->back();
    }

    public function conversions_delete(Request $request)
    {
        $currency_conversion    = CurrencyConversion::find($request->currency_conversion_id);

        if($currency_conversion->delete())
        {
            //delete
            session()->flash('success', 'currency conversion deleted successfully');
            return redirect()->back();
        }

        //error
        session()->flash('error', 'error deleting currency conversion');
        return redirect()->back();
    }
    public function world_currencies_delete(Request $request)
    {
        $world_currency         = Country::find($request->country_id);

        if($world_currency->currencies()->sync([]))
        {
            //delete
            session()->flash('success', 'currency for \''.$world_currency->name.'\' deleted successfully');
            return redirect()->back();
        }

        //error
        session()->flash('error', 'error deleting currencis in \''.$world_currency->name.'\'');
        return redirect()->back();
    }

    public function conversions_toggle_activate(CurrencyConversion $currency_conversion, Request $request)
    {
        if($currency_conversion->status)
        {
            //deactivate
            $currency_conversion->status   = 0;
            $currency_conversion->save();

            session()->flash('success', 'currency conversion deactivated successfully');
            return redirect()->back();
        }

        //activate
        $currency_conversion->status       = 1;
        $currency_conversion->save();

        session()->flash('success', 'currency conversion activated successfully');
        return redirect()->back();
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
    public function world_currencies_toggle_activate(Country $country, Request $request)
    {
        if($country->status)
        {
            //deactivate
            $country->status    = 0;
            $country->save();

            session()->flash('success', 'currency for \''.$country->name.'\' deactivated successfully');
            return redirect()->back();
        }

        //activate
        $country->status        = 1;
        $country->save();

        session()->flash('success', 'currency for \''.$country->name.'\' activated successfully');
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
