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

//インデックス画面に移行
Route::get('/pia_index', 'PayInfoController@index')->name('pia_index.list');
//支払情報入力
Route::get('/pianew_input', 'PayInfoController@newInput')->name('pianew.input');
//バリデーション実行し、セッションに入力値を送信
Route::post('/pianew_input', "PayInfoController@newSend")->name("pianew.send");
//入力内容確認
Route::get('/pianew_confirm', "PayInfoController@newConfirm")->name("pianew.confirm");
//入力内容をテーブルに登録
Route::post('/pianew_confirm','PayInfoController@newStore')->name('pianew.store');
//入力完了の表示
Route::get('/pianew_complete', "PayInfoController@newComplete")->name("pianew.complete");    

//明細照会条件入力
Route::get('/piainquiry_input', 'PayInfoController@inquiryInput')->name('piainquiry.input');
//明細照会確認へ
Route::get('/piainquiry_confirm', 'PayInfoController@inquiryConfirm')->name('piainquiry.confirm');
//照会CSVデータ生成、ダウンロード
Route::post('/piainquiry_confirm', 'PayInfoController@inquiryCsv')->name('piainquiry.csv');
/*照会ZIPデータ生成、ダウンロード（）
Route::post('/piainquiry_confirm', 'PayInfoController@inquiryZIP')->name('piainquiry.zip');
*/

Route::get('/', function () {
    return redirect('/pia_index');
});

/*
//インデックス画面に移行
Route::get('/tk_port')->name('tkport.list');
*/

//入力内容確認の関係



//認証関係
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
