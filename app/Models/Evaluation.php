<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['type', 'manager', 'date', 'status'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
