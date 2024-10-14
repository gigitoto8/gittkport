<?php

namespace App\Http\Controllers;

use App\Pay_info;
use App\Account_item;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;    //クエリビルダを利用
use Auth;                             //認証
use Validator;                        //バリデーション関係
use Carbon\Carbon;                    // Carbonを使用

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
        if(isset($request->kanryo)){                        //pianew_storeから移行した場合、$requestには値が入っている
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

    //月別支払状況　条件指定画面に移行
    public function expenseListSelect(){
        return view('expense_list_select');
    }

    //指定期間に基づきクエリ処理し、月別支払状況を表示
    public function expenseListShow(Request $request){
        
        //day_fromがday_toよりも後日付の場合、画面移動せず、警告文を表示    
        if(($request->dayFrom) > ($request->dayTo)){
            return redirect()->route('expense_list.select')
                ->withInput()
                ->withErrors("FROMがTOの後日付になっています。");
        }

        //全支払明細から、最古の支払日と最新の支払日を取得し、各変数に保管
        $oldestDate = DB::table('pay_infos')->where('user_id','=',Auth::user()->id)->min('pay_day');
        $newestDate = DB::table('pay_infos')->where('user_id','=',Auth::user()->id)->max('pay_day');
        //時期を指定した場合、それぞれの変数の値を変更
        if(isset($request->dayFrom)){
            $oldestDate = $request->dayFrom;
        }
        if(isset($request->dayTo)){
            $newestDate = $request->dayTo;
        }
        
        //支払時期の配列を作成。このデータは月別支払実績で表示する。
        //年月データに変換する
        $start = Carbon::parse($oldestDate)->startOfMonth();
        $end = Carbon::parse($newestDate)->endOfMonth();
        //配列に値を保管。最古月から最新月まで、1ヶ月毎の年月の文字列（yyyy-mm）を保存する。
        $months = [];
        while($start <= $end){
            $months[] = $start->format('Y-m');
            $start->addMonth();
        }
        
        // クエリの複雑さを管理しやすくするため、当メソッドはクエリビルダを使用。
        $results = DB::table('pay_infos')
                    ->select(
                        DB::raw('YEAR(pay_day)as year'),
                        DB::raw('MONTH(pay_day)as month'),
                        'account_items.id as id',
                        DB::raw('account_items.accnt_class as accnt_class'),
                        DB::raw('SUM(pay_infos.amount) as total'),            //月間の1科目の小計
                    )
                    ->join('account_items','pay_infos.accnt_class','=','account_items.accnt_class')
                    ->where('user_id','=',Auth::user()->id)
                    ->when($request->dayFrom, function($query,$start){
                        return $query->where('pay_day','>=',$start);
                    })
                    ->when($request->dayTo, function($query,$end){
                        return $query->where('pay_day','<=',$end);
                    })
                    ->groupBy('accnt_class','id','year','month')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->orderBy('id')
                    ->get();
                    
        // 各科目の合計を保存するための配列
        $totals = [];
        //科目リスト
        $accnt_classes = Account_item::whereNotNull('accnt_class')->pluck('accnt_class')->toArray();
        // 集計データを格納するための配列
        $data = [];
        foreach ($months as $month){
            foreach ($accnt_classes as $accnt_class){
                $data[$month][$accnt_class] = 0;
            }
        }
        //科目別合計額を格納する配列
        $totals = [];
        foreach($accnt_classes as $accnt_class){
            $totals[$accnt_class] = 0;
        }
        
        
        foreach($results as $result){
            $accnt_class = $result->accnt_class;
            $yearMonth = $result->year . '-' . str_pad($result->month,2,'0',STR_PAD_LEFT);
            
            // $months 配列が既に初期化されていることを確認してデータをセット
            if(!isset($data[$yearMonth])){
                $data[$yearMonth] = array_fill_keys($accnt_classes, 0);     //二次元配列に小計額を保管
            }
            
            // 該当月と科目に対して集計データを挿入
            $data[$yearMonth][$accnt_class] = $result->total;
            
            // 各科目の合計を計算
            $totals[$accnt_class] += $result->total;
        }
                    
        return view('expense_list_show',compact('data','accnt_classes','totals','months','oldestDate','newestDate'));
    }


}