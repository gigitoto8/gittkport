<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pay_info extends Model
{
    public function account_item()
    {
        return $this->belongsTo('App\Account_item');
    }
    
public function user()
    {
        return $this->belongsTo('App\User');
    }
}
