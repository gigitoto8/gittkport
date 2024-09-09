<?php

namespace App\Http\Controllers;

use App\Pay_info;
use App\Account_item;
use Illuminate\Http\Request;
use Auth;                             //
use Validator;                        //バリデーション関係


class PayInfoController extends Controller
{
    //バリデーション　明細入力確認用
    private $new_items = ['pay_day','payee','accnt_class',
                        'pay_detail','amount','rmk'];
    private $new_validator = [
        'pay_day'        => 'required',                     //支払日
        'payee'          => 'required|max:20',              //支払先
        'accnt_class'    => 'required',                     //勘定科目
        'pay_detail'     => 'required|max:20',              //支払内容
        'amount'         => 'required|max:10',              //金額（税込）
        'rmk'            => 'nullable|max:50',              //備考
        ];
        
    //PayInfoControllerオブジェクト初期化処理
    //ログアウト時に所定のメソッドを実行すると、自動的にログイン認証画面に移行する
    public function __construct()
    {
        $this->middleware('auth') ->except(['index']);
    }

    //ホーム画面に移行
    public function index()
    {
        return view('pia_index');
    }

    //account_itemsテーブルから勘定科目名を抽出し、支払情報入力画面に移行。
    public function input()
    {
        $account_items = Account_item::all()->pluck('accnt_class','accnt_class');
        return view('pianew_input',compact('account_items'));
    }

    //バリデーション実行。適正ならセッションに入力値を登録。
    public function send(Request $request){
        
        $inputs = $request->only($this->new_items);
        
        //バリデーション実行。入力値が適正でない場合、支払情報入力画面に戻る。
        $validator = Validator::make($inputs,$this->new_validator);
        if($validator->fails()){
            return redirect()->route('pianew.input')
                ->withInput()
                ->withErrors($validator);
        }
        //セッションに値を書き込む
        $request->session()->put("form_input", $inputs);    //
        return redirect()->route('pianew.confirm');
    }
    
    //セッションから値を取り出し、確認画面に表示させる。
    public function confirm(){
        //セッションから値を取り出す
        $input = session()->get('form_input');
        //セッションに値が無い時はフォームに戻る
		if(!$input){
			return redirect()->route('pianew.input');
		}
		return view('pianew_confirm',['input' => $input]);
    }

    //
    public function store(Request $request)
    {
        
        //セッションから値を取り出す
        $inputs = session()->get('form_input');
        
        //セッションに値が無い時はフォームに戻る
		if(!$inputs){
			return redirect()->route('pianew.input');
		}
		
		$pay_info = new Pay_info;
        $pay_info->pay_day     = $inputs['pay_day'];
        $pay_info->payee       = $inputs['payee'];
        $pay_info->accnt_class = $inputs['accnt_class'];
        $pay_info->pay_detail  = $inputs['pay_detail'];
        $pay_info->amount      = $inputs['amount'];
        $pay_info->rmk         = $inputs['rmk'];
        $pay_info->user_id     = Auth::user()->id;            //登録者ID ※use Authがない場合、Authの前にバックスラッシュが必要
        $pay_info->save();
        
        $request->session()->forget("form_input");
        $message = "入力は完了しました";                                    //pianew_completeに表示させる文字
        
        return redirect()->route('pianew.complete',compact('message'));    //$message変数をcompleteメソッドに渡す
    }

    //入力完了の画面
    public function complete(Request $request){
        if($request->message != "入力は完了しました"){                    //$messageの内容確認。URL直打対策も兼ねる
            return redirect()->route('pianew.input');
        }
        $message = $request->message;
        $request->message = 0;
        return view("pianew_complete",compact('message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pay_info  $pay_info
     * @return \Illuminate\Http\Response
     */
//照会入力ページに移動
    public function show()
    {
        $account_items = Account_item::all()->pluck('accnt_class','accnt_class');
        return view('pia_show',compact('account_items'));
    }

//明細照会ページに移動
    public function show_1(Request $request){

        //day_fromまたはday_toに入力がない場合、下限値または上限値を設定する
        if(is_null($request->day_from)){
            $request->day_from = '0000-01-01';
        }
        if(is_null($request->day_to)){
            $request->day_to = '9999-12-31';
        }
        
        //day_fromがday_toよりも後日付の場合、画面移動せず、警告文を表示    
        if(($request->day_from) > ($request->day_to)){
            return redirect()->route('pia.show')
                ->withInput()
                ->withErrors("FROMがTOの後日付になっています。");
        }
        
        //pia_show_1に送る変数と保存する値
        $inputs2 = array('day_from' => $request->day_from,
                        'day_to' => $request->day_to,
                        'accnt_class' => $request->accnt_class);

        //accnt_classの入力状況に応じて、テーブルからレコードを抽出
        $kamoku = $request->accnt_class;                //

        //CSVデータ用
        $pay_infos = Pay_info::where('user_id','=',Auth::user()->id)
                                                //↓勘定科目指定がある場合、where句を加える
                                                ->when($kamoku, function($query,$kamoku){
                                                    return $query->where('accnt_class','=',$kamoku);
                                                })
                                                ->whereBetween('pay_day',[$request->day_from,$request->day_to])
                                                ->get()->toArray();            //PDOオブジェクトではなく配列形式で保存
        //ページング用
        $pay_infos10 = Pay_info::where('user_id','=',Auth::user()->id)
                                                //↓勘定科目指定がある場合、where句を加える
                                                ->when($kamoku, function($query,$kamoku){
                                                    return $query->where('accnt_class','=',$kamoku);
                                                })
                                                ->whereBetween('pay_day',[$request->day_from,$request->day_to])
                                                ->paginate(10);
        
        //ヘルパーでセッションに検索条件を書き込む
        session(compact('pay_infos'));
        //変数requestは、pia_show_1.blade.phpでも使用する
        return view('pia_show_1',compact('pay_infos10','inputs2'));
    }

/** 
    //個々の入力明細を照会。
        public function show_1()
        {
            $pay_infos = Pay_info::orderby('id')->paginate(10);
            
            $shop = Shop::find($id);
            
            $user = \Auth::user();            //ログインユーザーの情報を変数に保存
            if($user){
                $login_user_id = $user->id;
            }else{
            $login_user_id = "";
            }
            return view('pia_show_1',['pay_infos'=>$pay_infos,  'login_user_id' => $login_user_id   ]);
        }
*/

/*    public function show(Pay_info $pay_info)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pay_info  $pay_info
     * @return \Illuminate\Http\Response
     */
    public function edit(Pay_info $pay_info)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pay_info  $pay_info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pay_info $pay_info)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pay_info  $pay_info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pay_info $pay_info)
    {
        //
    }

    /*
    public function createZIP(){
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

    public function createCSV(Request $request){
        $usersFromSession = session('pay_infos');
    
        // CSVデータを生成
        $head = ['明細管理番号','支払日','支払先','勘定科目','支払内容','金額（税込）'
                ,'備考','ユーザーID','登録日','更新日'];
        $f = fopen('php://output', 'w');
        ob_start();
        // ヘッダーの文字エンコーディングを変換し、書き込み
        mb_convert_variables('SJIS', 'UTF-8', $head);
        fputcsv($f, $head);
        // データのエンコーディングを変換し、各行を書き込み
        foreach ($usersFromSession as $pay_info) {
            mb_convert_variables('SJIS', 'UTF-8', $pay_info);
            fputcsv($f, $pay_info);
        }
        // ファイルを閉じる
        fclose($f);
        $csvContent = ob_get_clean();
        
        //ファイル名
        if(isset($request->filename)){
            $filename = $request->filename.'.csv';
        }else{
            $filename = 'test' . date('Y-m-d H:i:s') . '.csv';
        }
        
        // ZIPファイルをダウンロードさせる
        return response($csvContent)
            ->header('Content-Type','text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }


    /*creatrCSVメソッド　没
    public function createCSV(){
        //セッションから値を取り出す
        $usersFromSession = session('pay_infos');

        //CSVデータ作成
        //カラムの作成
        $head = ['明細管理番号','支払日','支払先','勘定科目','支払内容','金額（税込）','備考','ユーザーID','登録日','更新日'];
        // 書き込み用ファイルを開く
        $f = fopen('test.csv','w');
        if($f){
            //カラムの書き込み
            mb_convert_variables('SJIS', 'UTF-8', $head);
            fputcsv($f, $head);
            // データの書き込み
            foreach ($usersFromSession as $pay_info) {
                mb_convert_variables('SJIS', 'UTF-8', $pay_info);
                fputcsv($f, $pay_info);
            }
        }
        // ファイルを閉じる
        fclose($f);
        // HTTPヘッダ
        header("Content-Type: application/octet-stream");
        header('Content-Length: '.filesize('test.csv'));
        header('Content-Disposition: attachment; filename=test.csv');
        readfile('test.csv');
        
        return redirect()->route('pia.show_1');
    }
    */
}



