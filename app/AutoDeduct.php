<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoDeduct extends Model
{
    public function account_auto_deducts()
    {
    	return $this->hasMany('App\AccountAutoDeduct', 'member_id', 'member_id');
    }
}
