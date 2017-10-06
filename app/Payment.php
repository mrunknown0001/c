<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function payee()
    {
    	return $this->belongsTo('App\Member', 'user', 'uid');
    }
}
