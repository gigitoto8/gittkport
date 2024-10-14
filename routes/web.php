<?php

use Illuminate\Support\Facades\Route;
//バリデーション関係
use App\Http\Controllers\VaridatorController;
//ダウンロード関係
use App\Http\Controllers\DownloadController;
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

//メインページ関連
//メイン画面に移行
Route::get('/main', 'MainController@main')->name('main');
Route::get('/', function () {
    return redirect('/main');
});
//プロフィールに移行
Route::get('/profile', 'MainController@profile')->name('profile');

//認証関連
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//ダウンロード関係
Route::get('/download/{filename}', 'DownloadController@downloadFile')->name('download.file');

//更新履歴関係
//更新履歴メイン画面
Route::get('/updhis_main', 'UpdateHistoryController@updhisMain')->name('updhis.main');
//更新履歴入力画面
Route::get('/updhis_input', 'UpdateHistoryController@updhisInput')->name('updhis.input');
//入力内容をテーブルに登録
Route::post('/updhis_store','UpdateHistoryController@updhisStore')->name('updhis.store');   

//家計簿アプリ関連
//インデックス画面に移行
Route::get('/pia_main', 'PayInfoController@piaMain')->name('pia.main');
//（機能）支払情報入力
//入力画面
Route::get('/pianew_input', 'PayInfoController@newInput')->name('pianew.input');
//バリデーション実行、セッションに入力値を送信
Route::post('/pianew_input', "PayInfoController@newSend")->name("pianew.send");
//入力内容確認
Route::get('/pianew_confirm', "PayInfoController@newConfirm")->name("pianew.confirm");
//入力内容をテーブルに登録
Route::post('/pianew_confirm','PayInfoController@newStore')->name('pianew.store');   
//（機能）明細照会
//明細照会条件指定
Route::get('/piainquiry_input', 'PayInfoController@inquiryInput')->name('piainquiry.input');
//明細照会確認へ
Route::get('/piainquiry_confirm', 'PayInfoController@inquiryConfirm')->name('piainquiry.confirm');
//照会CSVデータ生成、ダウンロード
Route::post('/piainquiry_confirm', 'PayInfoController@inquiryCsv')->name('piainquiry.csv');
/*
照会ZIPデータ生成、ダウンロード（）
Route::post('/piainquiry_confirm', 'PayInfoController@inquiryZIP')->name('piainquiry.zip');
*/
//（機能）月別支払実績
//月別支払実績　条件指定
Route::get('/expense_list_select', 'PayInfoController@expenseListSelect')->name('expense_list.select');
//月別支払実績 表示
Route::get('/expense_list_show', 'PayInfoController@expenseListShow')->name('expense_list.show');