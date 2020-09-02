<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarder = [];

    public function users() {
        return $this->hasMany('App\User');
    }
}
