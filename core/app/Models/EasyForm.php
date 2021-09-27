<?php

namespace App\Models;

use App\Http\Controllers\Admin\EasyFormsController;
use Illuminate\Database\Eloquent\Model;

class EasyForm extends Model
{
    protected $fillable = [
        "easy_form_server_url",
        "easy_form_digital",
        "easy_form_restricted",
    ];

    // protected $casts = [
    //     "processed_easy_form_digital"     => 'json',
    //     "processed_easy_form_restricted"  => 'json',
    // ];


    public function getEasyFormDigitalAttribute($attribute)
    {
        try
        {
            return trim(e($attribute));
        }
        catch (\Exception $exception)
        {
            return $attribute;
        }
    }
    public function getEasyFormRestrictedAttribute($attribute)
    {

        try
        {
            return trim(e($attribute));
        }
        catch (\Exception $exception)
        {
            return $attribute;
        }
    }


    public function getProcessedEasyFormDigitalAttribute()
    {
        try
        {
            $field              = $this->easy_form_digital;
            return html_entity_decode((new EasyFormsController())->helper_parse_form($field));
        }
        catch (\Exception $exception)
        {
            return trim($this->easy_form_digital);
        }
    }
    public function getProcessedEasyFormRestrictedAttribute()
    {
        try
        {
            $field              = $this->easy_form_restricted;
            return html_entity_decode((new EasyFormsController())->helper_parse_form($field));
        }
        catch (\Exception $exception)
        {
            return trim($this->easy_form_restricted);
        }
    }
}
