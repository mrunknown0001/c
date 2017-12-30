<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentReference extends Model
{
    public function seller()
    {
    	return $this->belongsTo('App\User', 'member_id', 'id');
    }

    public function buyer()
    {
    	return $this->belongsTo('App\User', 'buyer_id', 'id');
    }

    public function seller_account()
    {
    	return $this->belongsTo('App\MemberAccount', 'member_account_id', 'id');
    }

    public function buyer_account()
    {
    	return $this->belongsTo('App\MemberAccount', 'buyer_account_id', 'id');
    }
}
