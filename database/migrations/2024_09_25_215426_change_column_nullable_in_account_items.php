<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNullableInAccountItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_items', function (Blueprint $table) {
            $table->string('accnt_class')->nullable()->change();
        });
        
        // '-' の値を null に変更
        DB::table('account_items')
            ->where('accnt_class', '-')
            ->update(['accnt_class' => null]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_items', function (Blueprint $table) {
            $table->string('accnt_class')->nullable(false)->change();
        });
        
        // null の値を '-' に戻す
        DB::table('account_items')
            ->whereNull('accnt_class')
            ->update(['accnt_class' => '-']);
    }
}
