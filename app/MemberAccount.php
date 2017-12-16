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

    public function downline_one()
    {
        return $this->hasOne('App\MemberAccount', 'id', 'downline_1');
    }

    public function downline_two()
    {
        return $this->hasOne('App\MemberAccount', 'id', 'downline_2');
    }

    public function downline_three()
    {
        return $this->hasOne('App\MemberAccount', 'id', 'downline_3');
    }

    public function downline_four()
    {
        return $this->hasOne('App\MemberAccount', 'id', 'downline_4');
    }

    public function downline_five()
    {
        return $this->hasOne('App\MemberAccount', 'id', 'downline_5');
    }
}
