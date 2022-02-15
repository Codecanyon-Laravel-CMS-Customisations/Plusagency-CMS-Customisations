<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'alpha_2_code',
        'alpha_3_code',
        'calling_codes',
        'alt_spellings',
        'region',
        'sub_region',
        'demonym',
        'timezones',
        'native_name',
        'status',
    ];

    protected $casts    = [
        'calling_codes' => 'array',
        'alt_spellings' => 'array',
        'timezones'     => 'array',
        'native_name'   => 'array',
        'status'        => 'boolean',
    ];

    public function getCallingCodesAttribute($calling_codes)
    {
        return explode(',', $calling_codes);
    }

    public function getAltSpellingsAttribute($alt_spellings)
    {
        return explode(',', $alt_spellings);
    }

    public function getTimezonesAttribute($timezones)
    {
        return explode(',', $timezones);
    }

    public function currencies()
    {
        return $this->belongsToMany(Currency::class)->withPivot('status')->withTimestamps();
    }
}
