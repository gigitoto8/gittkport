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
    
    protected $fillable = ['pay_day','accnt_class','amount'];
    // 'date' フィールドを日付として扱うように設定
    protected $dates = ['date'];
    
}
