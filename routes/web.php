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
//確認画面へ
Route::get('/pianew_confirm', "PayInfoController@confirm")->name("pianew.confirm");
//登録
Route::post('/pianew_confirm','PayInfoController@store')->name('pianew.store');
//完了
Route::get('/pianew_complete', "PayInfoController@complete")->name("pianew.complete");    


Route::get('/pia_show', 'PayInfoController@show')->name('pia.show');

Route::get('/pia_show_1', 'PayInfoController@show_1')->name('pia.show_1');

Route::post('/pia_show_1', 'PayInfoController@createZIP')->name('pia.crezip');


/*
Route::post('/pia_show_1', 'PayInfoController@createCSV')->name('pia.crecsv');
*/


/*
Route::post('/pia_show_1', 'PayInfoController@createXLSX')->name('pia.crexlsx');
*/



Route::get('/', function () {
    return redirect('/pia_index');
});

//入力内容確認の関係



//認証関係
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
