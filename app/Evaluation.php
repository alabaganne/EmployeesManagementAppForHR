<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluations extends Model
{
    protected $fillable = ['type', 'manager', 'date', 'status'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
