<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountSellCodeMonitor extends Model
{
    public function account()
    {
    	return $this->belongsTo('App\MemberAccount', 'account_id', 'id');
    }
}
