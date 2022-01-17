<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderV2 extends Model
{
    protected $fillable = [
        'slider_category'
    ];

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
