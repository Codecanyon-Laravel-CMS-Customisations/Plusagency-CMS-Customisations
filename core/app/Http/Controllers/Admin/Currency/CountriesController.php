<?php

namespace App\Http\Controllers\Admin\Currency;


use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountriesController extends Controller
{
    public function index() {
        $countries  = Country::all();
        return view('admin.currency.countries.index',
        compact('countries'));
    }

    public function edit(Country $country)
    {
        return view('admin.currency.countries.edit', compact('country'));
    }

    public function update(Request $request)
    {
        $country                = Country::findOrFail($request->country_id);

        // $request->validate([
        //     'name'  => 'required|unique:table,column,except,id'
        // ]);

        $request->validate([
            "name"              => "required|unique:countries,id,NULL,id,name,$request->name",
            "alpha_2_code"      => "required|unique:countries,id,NULL,id,alpha_2_code,$request->alpha_2_code",
            "alpha_3_code"      => "required|unique:countries,id,NULL,id,alpha_3_code,$request->alpha_3_code",
            // "calling_codes"     => "nullable|unique:countries,id,NULL,id,calling_codes,$request->calling_codes",
        ]);


        $country->name              = trim($request->name);
        $country->alpha_2_code      = trim($request->alpha_2_code);
        $country->alpha_3_code      = trim($request->alpha_3_code);
        $country->calling_codes     = str_replace('"', '', str_replace('[', '', str_replace(']', '', $request->calling_codes)));
        $country->region            = trim($request->region);
        $country->sub_region        = trim($request->sub_region);
        $country->demonym           = trim($request->demonym);
        $country->status            = trim($request->status);
        $country->save();

        session()->flash('success', 'country updated successfully');
        return "success";
    }
    public function toggle_activate(Country $country, Request $request)
    {
        if($country->status)
        {
            //deactivate
            $country->status   = 0;
            $country->save();

            session()->flash('success', 'country deactivated successfully');
            return redirect()->back();
        }

        //activate
        $country->status       = 1;
        $country->save();

        session()->flash('success', 'country activated successfully');
        return redirect()->back();
    }
    public function delete(Request $request)
    {
        try
        {
            $country               = Country::find($request->country_id);

            if(!empty($country))
            {
                //only make this feature temporary
                if(date('M/Y') == "Jan/2022")
                {
                    //delete
                    $country->delete();
                    session()->flash('success', 'country deleted successfully');
                    return redirect()->back();
                }
                session()->flash('warning', 'Country deletion feature not available at the moment');
                return redirect()->back();
            }
        }
        catch(\Exception $exception)
        {}

        //error
        session()->flash('error', 'error deleting country');
        return redirect()->back();
    }
}
