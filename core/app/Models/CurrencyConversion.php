<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyConversion extends Model
{
    protected $fillable = [
        'rate',
        'status',
        'base_currency_id',
        'converted_currency_id',
    ];

    protected $casts    = [
        'rate'          => 'float',
        'status'        => 'boolean',
    ];

    public function baseCurrency()
    {
        return $this->belongsTo(Currency::class, 'base_currency_id');
    }
    public function convertedCurrency()
    {
        return $this->belongsTo(Currency::class, 'converted_currency_id');
    }

    public function baseCurrencies()
    {
        return $this->belongsToMany(Currency::class, 'base_currency_id');
    }

    public function convertedCurrencies()
    {
        return $this->belongsToMany(Currency::class, 'converted_currency_id');
    }
}
