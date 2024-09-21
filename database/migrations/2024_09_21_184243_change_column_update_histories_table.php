<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeColumnUpdateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('update_histories', function (Blueprint $table) {
            // 新しいカラムを追加
            $table->string('detail')->after('title');
        });

        // 古いカラムのデータを新しいカラムに移行
        DB::table('update_histories')->update(['detail' => DB::raw('title')]);
    
        Schema::table('update_histories', function (Blueprint $table) {
            // 古いカラムを削除
            $table->dropColumn('title');
        });
        //renameColumn メソッドを使用するには doctrine/dbal パッケージが必要だが、
        //インストールできないので、上記の手順に変更
        
        Schema::table('update_histories', function (Blueprint $table) {
            // コメントを追加
            $table->string('update_date')->comment('投稿日')->change();
            $table->string('detail')->comment('更新詳細')->change();
        });
        
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('update_histories', function (Blueprint $table) {
            //
        });
    }
}
