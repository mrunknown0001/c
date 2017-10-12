<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberBalance extends Model
{
    public function member()
    {
    	return $this->belongsTo('App\Member', 'uid', 'uid');
    }
}
