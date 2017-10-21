<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    public function member()
    {
    	return $this->belongsTo('App\Member', 'user', 'uid');
    }
}
