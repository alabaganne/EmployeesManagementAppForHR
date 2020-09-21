<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['type', 'manager', 'date', 'status'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
