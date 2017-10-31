<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingDownline extends Model
{
    public function member()
    {
    	return $this->belongsTo('App\MemberAccount', 'account_id', 'account_id');
    }
}
