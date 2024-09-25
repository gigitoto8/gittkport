<?php

namespace App\Http\Controllers;

use App\UpdateHistory;
use Illuminate\Http\Request;

class UpdateHistoryController extends Controller
{
    // 更新履歴一覧を表示
    public function index()
    {
        $histories = UpdateHistory::all();
        return view('update_histories.index', compact('histories'));
    }

    // 更新履歴を保存
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'detail' => 'required',
            'update_date' => 'required|date',
        ]);

        UpdateHistory::create($request->all());

        return redirect()->route('update_histories.index');
    }
    
    //上記　参考
    
    //更新履歴編集メインページ
    public function updhisMain()
    {
        $re_his = UpdateHistory::orderBy('id', 'desc')->get();
        return view('updhis_main',compact('re_his'));
    }
    
    //更新履歴入力ページ
    public function updhisInput()
    {
        return view('updhis_input');
    }
    
    //更新履歴保存
    public function updhisStore(Request $request){
        /*
        //セッションから値を取り出す
        $inputs = session()->get('form_input');
        
        //セッションに値が無い時はフォームに戻る
		if(!$inputs){
			return redirect()->route('pianew.input');
		}
		*/
		
		//pay_infosテーブルに登録
		$upd_his = new UpdateHistory;
        $upd_his->update_date     = $request->update_date;
        $upd_his->detail          = $request->detail;
        $upd_his->rmk             = $request->rmk;
        $upd_his->save();
        
        //セッション中身消去
        
        return redirect()->route('updhis.main');
    }        
}
