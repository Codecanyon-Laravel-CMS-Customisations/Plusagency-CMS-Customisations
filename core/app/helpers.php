<?php

use App\Product;
use App\BasicExtra;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Str;
use App\Models\CurrencyConversion;
use App\Models\GeoIP\ClientGeoData;
use App\Services\CountryManager;

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
            $bc_id      = Currency::query()->where('acronym', 'INR')->orderBy('id', 'desc')->first();
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
            $bc_id      = Currency::query()->where('acronym', 'INR')->orderBy('id', 'desc')->first();
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

if(! function_exists('ship_to_india'))
{//Resolve country from IoC container to avoid duplicate requests
    function ship_to_india()
    {
        try
        {
            $country = app()->make('user_country');
            
            // if no country selected then INR will be by default
            if (is_null($country)) {
                return true;
            }

            if(Str::slug($country->name) == Str::slug('India'))
            {
                return true;
            }
            return false;
        }
        catch(\Exception $exception)
        {
            return false;
        }
        return false;
    }
}




/**
 * Detect client device
 */
if(! function_exists('is_mobile'))
{
    function is_mobile()
    {
        try
        {
            $useragent  = $_SERVER['HTTP_USER_AGENT'];
            if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
            {
                return true;
            }
            return false;

        }
        catch (\Exception $exception)
        {
            return false;
        }
    }
}



/**
 * Product in location
 */
if(! function_exists('product_in_location'))
{
    function product_in_location(Product $product)
    {
        try
        {
            if(ship_to_india())
            {
                if(trim($product->current_price) == '') return false;
                return true;
            }
            else
            {
                if(trim($product->current_price_international) == '') return false;
                return true;
            }

        }
        catch (\Exception $exception)
        {
            return false;
        }
    }
}
