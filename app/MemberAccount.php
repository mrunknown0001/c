<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberAccount extends Model
{
    public function member()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function codes()
    {
        return $this->hasMany('App\SellCodeOwner', 'member_account', 'id');
    }
}
