<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'name',
        'acronym',
        'symbol',
        'symbol_position',
        'text_position',
        'status',
    ];

    protected $casts    = [
        'status'        => 'boolean',
    ];

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    public function conversion()
    {
        return $this->hasOne(CurrencyConversion::class, 'converted_currency_id');
    }
}
