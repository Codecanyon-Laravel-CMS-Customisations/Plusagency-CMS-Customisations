<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasicSettingsColor extends Model
{
    protected $table    =   "basic_settings_colors";
    protected $fillable = ['color_name', 'color_value'];
}
