<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('update_date'); // 更新日
            $table->text('detail');    // 詳細
            $table->text('rmk');       // 備考
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
        Schema::dropIfExists('update_histories');
    }
}
