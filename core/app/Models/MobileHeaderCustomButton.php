<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileHeaderCustomButton extends Model
{
    protected $fillable = [
        'link_text', 'link_url', 'link_target',
        'description', 'link_rank', 'status'
    ];

    protected $casts    = [
        'rank'          => 'integer',
        'status'        => 'boolean',
    ];
}
