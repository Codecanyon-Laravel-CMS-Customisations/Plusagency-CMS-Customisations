<?php

use App\BasicExtended;
use App\Models\Currency;
use App\Models\CurrencyConversion;
use App\Models\GeoIP\ClientGeoData;
use App\BasicExtra;
use App\Produc;

if (! function_exists('angel_auto_convert_currency'))
{
    function angel_auto_convert_currency($currency, $currency_from_id, $currency_to_id)
    {
        //$currency = 1;
        try
        {
            //get client location
            $client_ip  = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

            if(auth()->id())
            {
                $geo_data   = ClientGeoData::query()->with('country', 'currency')->where('user_id', auth()->id())->orderBy('id', 'desc')->first();
            }
            else
            {
                $geo_data   = ClientGeoData::query()->with('country', 'currency')->where('ip', $client_ip)->orderBy('id', 'desc')->first();
            }

            //return json_encode($geo_data);


            if(!$geo_data) return str_replace('.00', '', number_format($currency, 2));

            //get currency conversion
            $currency_conversion_from   = CurrencyConversion::query()->where('converted_currency_id', $currency_from_id)->orderBy('id', 'desc')->first();
            $currency_conversion_to     = CurrencyConversion::query()->where('converted_currency_id', $currency_to_id)->orderBy('id', 'desc')->first();

            //convert to usd
            $c_to_usd                   = (double) $currency / (double) $currency_conversion_from->rate;
            //convert to new currency
            $c_to_new_currency          = $c_to_usd * (double) $currency_conversion_to->rate;

            return str_replace('.00', '', number_format($c_to_new_currency, 2));
        }
        catch (\Exception $exception)
        {
            return $currency;
        }
    }
}


if (! function_exists('angel_get_base_currency_id'))
{
    function angel_get_base_currency_id()
    {
        try
        {
            //get from session
            if(session()->has('geo_data_base_currency'))
            {
                $bc_id      = Currency::find(session('geo_data_base_currency'));
                return $bc_id->id;
            }

            //get from site settings
            $bc_id      = Currency::query()->where('name', BasicExtra::first()->base_currency_text)->orderBy('id', 'desc')->first();
            return $bc_id->id;
        }
        catch (\Exception $exception)
        {
            return false;
        }
    }
}


if (! function_exists('angel_get_user_currency_id'))
{
    function angel_get_user_currency_id()
    {
        try
        {
            //get from session
            if(session()->has('geo_data_user_currency'))
            {
                $bc_id      = Currency::find(session('geo_data_user_currency'));
                return $bc_id->id;
            }

            //get from site settings
            $bc_id      = Currency::query()->where('name', BasicExtra::first()->base_currency_text)->orderBy('id', 'desc')->first();
            return $bc_id->id;
        }
        catch (\Exception $exception)
        {
            return false;
        }
    }
}


if (! function_exists('angel_get_user_country_id'))
{
    function angel_get_user_country_id()
    {
        try
        {
            //get from session
            // if(session()->has('geo_data_user_country'))
            // {
            //     $bc_id      = Currency::find(session('geo_data_user_currency'));
            //     return $bc_id->id;


            //     $world_currencies   = Country::with('currencies')->whereHas('currencies')->get()->sortBy('name', 0, false);
            //     $countries          = Country::all()->sortBy('name', 0, false);
            //     $currencies         = Currency::with('conversion')->whereHas('conversion')->orderBy('name', 'asc');

            // }

            // //get from site settings
            // $bc_id      = Currency::query()->where('name', BasicExtra::first()->base_currency_text)->orderBy('id', 'desc')->first();
            // return $bc_id->id;
        }
        catch (\Exception $exception)
        {
            return false;
        }
    }
}




/**
 * New currency methods
 */


if (! function_exists('angel_product_price'))
{
    function angel_product_price(\App\Product $product, $currency = "USD")
    {
        //$currency = 1;
        try
        {
            //get client location
            $client_ip  = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

            if(auth()->id())
            {
                $geo_data   = ClientGeoData::query()->with('country', 'currency')->where('user_id', auth()->id())->orderBy('id', 'desc')->first();
            }
            else
            {
                $geo_data   = ClientGeoData::query()->with('country', 'currency')->where('ip', $client_ip)->orderBy('id', 'desc')->first();
            }

            //return json_encode($geo_data);


            if(!$geo_data) return str_replace('.00', '', number_format($currency, 2));

            //get currency conversion
            $currency_conversion_from   = CurrencyConversion::query()->where('converted_currency_id', $currency_from_id)->orderBy('id', 'desc')->first();
            $currency_conversion_to     = CurrencyConversion::query()->where('converted_currency_id', $currency_to_id)->orderBy('id', 'desc')->first();

            //convert to usd
            $c_to_usd                   = (double) $currency / (double) $currency_conversion_from->rate;
            //convert to new currency
            $c_to_new_currency          = $c_to_usd * (double) $currency_conversion_to->rate;

            return str_replace('.00', '', number_format($c_to_new_currency, 2));
        }
        catch (\Exception $exception)
        {
            return $currency;
        }
    }
}
