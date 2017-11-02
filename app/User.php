<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function accounts()
    {
        return $this->hasMany('App\MemberAccount', 'user_id', 'id');
    }


    public function codes()
    {
        return $this->hasMany('App\SellCodeOwner', 'member_uid', 'uid');
    }

    public function member()
    {
        return $this->hasOne('App\Member', 'uid', 'uid');
    }

    public function cash()
    {
        return $this->hasOne('App\MyCash', 'user_id', 'id');
    }

    public function avatar()
    {
        return $this->hasOne('App\Avatar', 'user_id', 'id');
    }

    public function autodeduct()
    {
        return $this->hasOne('App\AutoDeduct', 'member_id', 'uid');
    }
}
