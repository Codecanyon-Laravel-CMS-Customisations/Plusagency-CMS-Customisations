<?php

namespace App\Http\Middleware;

use App\Models\Country;
use App\Models\GeoIP\ClientGeoData;
use Closure;

class AutoRecordVisitorLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->get_ip();
        return $next($request);
    }

    public function get_ip()
    {
        $client_ip  = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

        if(auth()->user())
        {
            $status     = ClientGeoData::all()
            ->where('user_id', auth()->id())
            ->where('unix_expiry_time', '>=', time())
            ->count();
        }
        else
        {
            $status     = ClientGeoData::all()
            ->where('ip', $client_ip)
            ->where('unix_expiry_time', '>=', time())
            ->count();
        }

        if($status)
        {
            //record already in the database and is up-to-date
        }
        else
        {
            try
            {
                //call the api and get latest data
                $url        = config('geoip.url').$client_ip.'?apikey='.config('geoip.api_key');
                $ch         = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $response = json_decode(curl_exec($ch));
                curl_close($ch);

                echo json_encode($response);
                echo "<hr/>";
                echo $url;
                echo "<hr/>";

                //store in database
                $geodata                    = ClientGeoData::firstOrCreate(['ip'    => $response->ip]);
                $geodata->ip                = $response->ip;
                $geodata->country_code      = $response->country_code;
                $geodata->country_name      = $response->country_name;
                $geodata->region_code       = $response->region_code;
                $geodata->region_name       = $response->region_name;
                $geodata->city              = $response->city;
                $geodata->zip_code          = $response->zip_code;
                $geodata->time_zone         = $response->time_zone;
                $geodata->latitude          = $response->latitude;
                $geodata->longitude         = $response->longitude;
                $geodata->metro_code        = $response->metro_code;
                $geodata->unix_expiry_time  = intval(time()+(60*60*24*30)); //+30days

                $country                    = Country::query()->where('alpha_2_code', $response->country_code)->first();
                if($country)
                { $geodata->country_id      = $country->id; }
                if(auth()->user())
                { $geodata->user_id         = auth()->id(); }
                $geodata->save();


                //set client session
                session()->put('geo_data_user_country', $country->id);
            }
            catch (\Exception $exception) {
                echo $exception->getTraceAsString();
                echo $exception->getMessage();
            }
        }

        //return ClientGeoData::query()->where('ip', $client_ip)->first();
    }
}
