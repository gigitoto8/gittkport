<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdateHistory extends Model
{
    protected $table = 'update_histories';

    // 更新履歴に記録するカラムを指定
    protected $fillable = ['update_date', 'detail', 'urmk'];
}
