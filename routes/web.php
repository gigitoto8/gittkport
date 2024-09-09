<?php

//バリデーション関係
use App\Http\Controllers\VaridatorController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/pia_index', 'PayInfoController@index')->name('pia_index.list');

//明細入力画面へ
Route::get('/pianew_input', 'PayInfoController@input')->name('pianew.input');
//セッションに入力値を送信
Route::post('/pianew_input', "PayInfoController@send")->name("pianew.send");
//入力内容確認画面へ
Route::get('/pianew_confirm', "PayInfoController@confirm")->name("pianew.confirm");
//入力内容をデータベースに登録
Route::post('/pianew_confirm','PayInfoController@store')->name('pianew.store');
//登録完了画面へ
Route::get('/pianew_complete', "PayInfoController@complete")->name("pianew.complete");    

//明細照会画面（条件入力）へ
Route::get('/pia_show', 'PayInfoController@show')->name('pia.show');
//明細照会画面（結果表示）へ
Route::get('/pia_show_1', 'PayInfoController@show_1')->name('pia.show_1');
//CSVデータ生成、ダウンロード
Route::post('/pia_show_1', 'PayInfoController@createCSV')->name('pia.crecsv');
/*ZIPデータ生成、ダウンロード（）
Route::post('/pia_show_1', 'PayInfoController@createZIP')->name('pia.crezip');
*/

Route::get('/', function () {
    return redirect('/pia_index');
});

//入力内容確認の関係



//認証関係
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
