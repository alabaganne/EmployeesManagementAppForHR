<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    protected $guard_name = 'api'; // ! https://github.com/spatie/laravel-permission/issues/686

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // ? Check if user is admin
    public function isAdmin() {
        return $this->hasRole('admin');
    }

    // ! Relationships
    public function department() {
        return $this->belongsTo('App\Department');
    }

    public function evaluations() {
        return $this->hasMany('App\Evaluation');
    }

    public function skills() {
        return $this->hasMany('App\Skill');
    }

    public function trainings() {
        return $this->hasMany('App\Training');
    }

    public function leaves() {
        return $this->hasMany('App\Leave');
    }
}
