<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellCodeOwner extends Model
{
    public function code()
    {
    	return $this->belongsTo('App\SellActivationCode');
    }

    public function owner()
    {
    	return $this->belongsTo('App\User', 'member_uid', 'uid');
    }

    public function account()
    {
    	return $this->belongsTo('App\MemberAccount', 'account_id', 'id');
    }
}
