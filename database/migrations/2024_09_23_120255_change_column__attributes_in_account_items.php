<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnAttributesInAccountItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_items', function (Blueprint $table) {
            $table->bigIncrements('id',5)->change(); // 文字列型、長さ5
            $table->string('accnt_class',20)->comment('科目')->change(); //文字数・コメント変更
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_items', function (Blueprint $table) {
            //
        });
    }
}
