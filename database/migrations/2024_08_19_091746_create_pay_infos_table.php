<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('pay_day');
            $table->string('payee'); 
            $table->string('accnt_class');
            $table->text('pay_detail');
            $table->int('amount');
            $table->text('rmk');
            $table->integer('user_id');
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
        Schema::dropIfExists('pay_infos');
    }
}
