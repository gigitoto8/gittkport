<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnAttributesInPayInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pay_infos', function (Blueprint $table) {
            //キーカラムの操作は推奨されない
            $table->date('pay_day')->comment('支払日')->change(); // コメント追加
            $table->string('payee',20)->comment('支払先')->change(); // コメント追加、文字数変更
            $table->string('accnt_class',20)->comment('科目')->change(); // コメント追加、文字数変更
            $table->text('pay_detail')->comment('内容')->change(); // コメント追加
            $table->integer('amount')->comment('金額（税込）')->change(); // コメント追加、文字数変更
            $table->text('rmk')->comment('備考')->nullable()->change(); // コメント追加、nullable
            $table->integer('user_id')->comment('登録ユーザーID')->change();//コメント追加
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pay_infos', function (Blueprint $table) {
            //
        });
    }
}
