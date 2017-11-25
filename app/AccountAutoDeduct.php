<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountAutoDeduct extends Model
{
    public function member_auto_deduct()
    {
    	return $this->belongsTo('App\AutoDeduct', 'member_id', 'member_id');
    }

    public function account()
    {
    	return $this->belongsTo('App\MemberAccount', 'account_id', 'account_id');
    }
}
