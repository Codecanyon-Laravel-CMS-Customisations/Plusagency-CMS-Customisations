<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'admin_id',
        'product_id',
        'ticket_number',
        'subject',
        'message',
        'zip_file',
        'last_message'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
        ->withPivot('user_id', 'email');
    }

    public function messages() {
        return $this->hasMany('App\Conversation');
      }
    public function admin() {
        return $this->belongsTo('App\Admin');
      }
    public function user() {
        $email              = null;
        try
        {
            $email          = $this->products()->first()->pivot->email;
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $this->belongsTo('App\User')->withDefault(function($user, $ticket) use($email) {
            $user->username = "Guest User";
            $user->email    = $email;//$ticket->pivot->email;
        });
    }

}
