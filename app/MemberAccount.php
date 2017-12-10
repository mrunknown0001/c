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

    public function ad_fund()
    {
    	return $this->hasOne('App\AccountAutoDeduct', 'account_id', 'account_id');
    }

    public function activation()
    {
        return $this->hasOne('App\AccountActivation', 'account_id', 'id');
    }
}
