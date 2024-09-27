<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class main extends Model
{
    public function updatehistory()
    {
        return $this->belongsTo('App\UpdateHistory');
    }
}
