<?php

namespace App\Http\Controllers;

use App\Pay_info;
use App\Account_item;
use Illuminate\Http\Request;
use Auth;                             //
use Validator;                        //バリデーション関係


class PayInfoController extends Controller
{
        
    //PayInfoControllerオブジェクト初期化処理
    //ログアウト時に所定のメソッドを実行すると、自動的にログイン認証画面に移行する
    public function __construct()
    {
        $this->middleware('auth') ->except(['index']);
    }

    //以下、メソッド

    //インデックス画面に移行
    public function piaMain()
    {
        return view('pia_main');
    }

    //account_itemsテーブルから科目名を抽出し、支払情報入力画面に移行
    public function newInput(Request $request)
    {
        $kanryo2 = null;                            //pianew_inputに渡す変数の初期化
        if(isset($request)){                        //pianew_storeから移行した場合、$requestには値が入っている
            $kanryo2 = '入力は完了しました';            //
        }
        //セレクトボックスに使用する科目データ（科目名）を抽出
        $account_items = Account_item::all()->pluck('accnt_class','accnt_class');
        return view('pianew_input',compact('account_items','kanryo2'));
    }

    //バリデーション実行。適正ならセッションに入力値を送信し、'pianew.confirm'へリダイレクト。
    public function newSend(Request $request){

        //バリデーション
        $new_items = ['pay_day','payee','accnt_class',
                            'pay_detail','amount','rmk'];
        $new_validator = [
            'pay_day'        => 'required',                     //支払日
            'payee'          => 'required|max:20',              //支払先
            'accnt_class'    => 'required',                     //科目
            'pay_detail'     => 'required|max:20',              //支払内容
            'amount'         => 'required|digits_between:1,10', //金額（税込）
            'rmk'            => 'nullable|max:50',              //備考
            ];
        
        $inputs = $request->only($new_items);
        
        //バリデーション実行。入力値が適正でない場合、支払情報入力画面に戻る。
        $validator = Validator::make($inputs,$new_validator);
        if($validator->fails()){
            return redirect()->route('pianew.input')
                ->withInput()
                ->withErrors($validator);
        }
        //セッションに値を書き込む
        $request->session()->put("form_input", $inputs);
        return redirect()->route('pianew.confirm');
    }
    
    //セッションから値を取り出し、入力内容確認画面に移行。
    public function newConfirm(){
        //セッションから値を取り出す
        $input = session()->get('form_input');
        //セッションに値が無い時はフォームに戻る
		if(!$input){
			return redirect()->route('pianew.input');
		}
		return view('pianew_confirm',['input' => $input]);
    }

    //入力情報をpay_infosテーブルに登録し、'pianew.complete'へリダイレクト。
    public function newStore(Request $request)
    {
        
        //セッションから値を取り出す
        $inputs = session()->get('form_input');
        
        //セッションに値が無い時はフォームに戻る
		if(!$inputs){
			return redirect()->route('pianew.input');
		}
		
		//pay_infosテーブルに登録
		$pay_info = new Pay_info;
        $pay_info->pay_day     = $inputs['pay_day'];
        $pay_info->payee       = $inputs['payee'];
        $pay_info->accnt_class = $inputs['accnt_class'];
        $pay_info->pay_detail  = $inputs['pay_detail'];
        $pay_info->amount      = $inputs['amount'];
        $pay_info->rmk         = $inputs['rmk'];
        $pay_info->user_id     = Auth::user()->id;            //登録者ID ※use Authがない場合、Authの前にバックスラッシュが必要
        $pay_info->save();
        
        //セッション中身消去
        $request->session()->forget("form_input");
        $kanryo = 1;                                                //入力完了フラグ
        
        return redirect()->route('pianew.input',compact('kanryo'));    //$kanryo変数をpianewInputメソッドに渡す
    }

    //照会条件入力画面に移動
    public function inquiryInput()
    {
        //account_itemsテーブルから科目名を抽出し、照会条件入力画面に移行。
        $account_items = Account_item::all()->pluck('accnt_class','accnt_class');
        return view('piainquiry_input',compact('account_items'));
    }

    //明細照会画面に移動
    public function inquiryConfirm(Request $request){

        //day_fromまたはday_toに入力がない場合、下限値または上限値を設定する
        //併せて、照会条件を文字列として$period_mess変数に保存
        if(is_null($request->day_from) && is_null($request->day_to)){
            $request->day_from = '0000-01-01';
            $request->day_to = '9999-12-31';
            $period_mess = '全期間';
        }elseif(is_null($request->day_from)){
            $request->day_from = '0000-01-01';
            $period_mess = $request->day_to . ' まで'; 
        }elseif(is_null($request->day_to)){
            $request->day_to = '9999-12-31';
            $period_mess = $request->day_from . ' から'; 
        }else{
            $period_mess = $request->day_from . ' から ' . $request->day_to . ' まで'; 
        }
        
        //day_fromがday_toよりも後日付の場合、画面移動せず、警告文を表示    
        if(($request->day_from) > ($request->day_to)){
            return redirect()->route('piainquiry.input')
                ->withInput()
                ->withErrors("FROMがTOの後日付になっています。");
        }
        
        //accnt_classの入力状況に応じて、テーブルからレコードを抽出
        $kamoku = $request->accnt_class;
        
        //照会条件を文字列として$kamoku_mess変数に保存
        if(isset($kamoku)){
            $kamoku_mess = $kamoku;
        }else{
            $kamoku_mess = '全科目';
        }
        
        //検索条件メッセージを$messages変数に保存。
        //配列にしたのは、配列データでないとCSVを作成できないため。
        $messages = array('検索条件　' , '期間：' , $period_mess , '' , '' , '　|　' , '科目：' , $kamoku_mess);
        
        
        //クエリデータ（CSVデータ用）
        $pay_infos = Pay_info::where('user_id','=',Auth::user()->id)
                                                //↓科目が指定されている場合、where句を加える
                                                ->when($kamoku, function($query,$kamoku){
                                                    return $query->where('accnt_class','=',$kamoku);
                                                })
                                                ->whereBetween('pay_day',[$request->day_from,$request->day_to])
                                                ->get()->toArray();            //PDOオブジェクトではなく配列形式で保存
        //クエリデータ（照会画面用）。
        $pay_infos10 = Pay_info::where('user_id','=',Auth::user()->id)
                                                //↓科目が指定されている場合、where句を加える
                                                ->when($kamoku, function($query,$kamoku){
                                                    return $query->where('accnt_class','=',$kamoku);
                                                })
                                                ->whereBetween('pay_day',[$request->day_from,$request->day_to])
                                                ->paginate(10);
        
        //クエリデータ（CSVデータ用）と検索条件メッセージをセッションに書き込む
        session(compact('pay_infos','messages'));
        //クエリデータ（照会画面用）と検索条件メッセージをViewに送る
        return view('piainquiry_confirm',compact('pay_infos10','messages'));
    }


    public function edit(Pay_info $pay_info)
    {
        //
    }

    public function update(Request $request, Pay_info $pay_info)
    {
        //
    }

    public function destroy(Pay_info $pay_info)
    {
        //
    }


    //CSVデータ作成とダウンロード
    public function inquiryCSV(Request $request){
        //セッションからクエリごデータを抽出。
        $usersFromSession = session('pay_infos');    //クエリデータ
        $head = session('messages');    //検索条件メッセージ
    
        // CSVデータを生成
        //項目列
        $head2 = ['明細管理番号','支払日','支払先','勘定科目','支払内容','金額（税込）'
                ,'備考','ユーザーID','登録日','更新日'];
        $f = fopen('php://output', 'w');
        ob_start();
        
        // ヘッダーデータをエンコーディングし、書き込む
        mb_convert_variables('SJIS', 'UTF-8', $head);
        fputcsv($f, $head);
        mb_convert_variables('SJIS', 'UTF-8', $head2);
        fputcsv($f, $head2);
        // クエリデータをエンコーディングし、各行を書き込む
        foreach ($usersFromSession as $pay_info) {
            mb_convert_variables('SJIS', 'UTF-8', $pay_info);
            fputcsv($f, $pay_info);
        }
        // ファイルを閉じる
        fclose($f);
        $csvContent = ob_get_clean();
        
        //ファイル名。
        //指定がなければ、DL日時を含めたファイル名を設定。（"test yyyy-mm-dd hh_mm_ss.csv"）
        if(isset($request->filename)){
            $filename = $request->filename.'.csv';
        }else{
            $filename = 'test ' . date('Y-m-d H:i:s') . '.csv';
        }
        
        // CSVファイルをダウンロードする
        return response($csvContent)
            ->header('Content-Type','text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /*
    public function inquiryZIP(){
        $pay_infos = session()->get('pay_infos');
        $head = ['明細管理番号','支払日','支払先','勘定科目','支払内容','金額（税込）'
                ,'備考','ユーザーID','登録日','更新日'];
    
        // CSVデータを出力するためのストリームを生成
        $f = fopen('test.csv', 'w');
        // ヘッダーの文字エンコーディングを変換し、書き込み
        mb_convert_variables('SJIS', 'UTF-8', $head);
        fputcsv($f, $head);
        // データのエンコーディングを変換し、各行を書き込み
        foreach ($pay_infos as $pay_info) {
            mb_convert_variables('SJIS', 'UTF-8', $pay_info);
            fputcsv($f, $pay_info);
        }
        // ファイルを閉じる
        fclose($f);
        
        // CSVデータを一時ファイルに保存してZIP化
        $zip = new \ZipArchive();
        $zipFileName = 'test.zip';
        $zip->open($zipFileName,\ZipArchive::CREATE);    //同値演算子　値だけでなく、型も同じ場合にtrueを返
        $file_info = pathinfo('test.csv');
        $zip->addFile('test.csv');
        $zip->close();

        // ZIPファイルをダウンロードさせる
        return response()->download($zipFileName);
    }
    */

}