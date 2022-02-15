<?php

namespace App\Models\GeoIP;

use App\Models\Country;
use App\Models\Currency;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ClientGeoData extends Model
{
    protected $fillable = [
        'ip', 'country_code', 'country_name', 'region_code',
        'region_name', 'city', 'zip_code', 'time_zone', 'latitude',
        'longitude', 'metro_code', 'unix_expiry_time', 'user_id', 'country_id', 'currency_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);//->withDefault();
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);//->withDefault();
    }
    public function country()
    {
        return $this->belongsTo(Country::class);//->withDefault();
    }
}
