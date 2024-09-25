<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateUpdateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //テーブル再作成の処理を記述
        Schema::create('update_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('update_date'); // 更新日
            $table->text('detail');    // 詳細
            $table->text('rmk')->nullable();       // 備考
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
