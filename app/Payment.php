<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function payee()
    {
    	return $this->belongsTo('App\Member', 'user', 'uid');
    }

    public function account()
    {
    	return $this->belongsTo('App\MemberAccount', 'account_id', 'id');
    }
}
