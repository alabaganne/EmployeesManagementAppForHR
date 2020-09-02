<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongTo('App\User');
    }
}
