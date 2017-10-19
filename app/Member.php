<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User', 'uid', 'uid');
    }

    public function balance()
    {
    	return $this->hasOne('App\MemberBalance', 'uid', 'uid');
    }


}
