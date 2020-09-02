<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    public $fillable = ['days'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
