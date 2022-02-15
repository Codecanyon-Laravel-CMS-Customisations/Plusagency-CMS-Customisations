<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'email_type', 'email_subject', 'email_body'
    ];
}
