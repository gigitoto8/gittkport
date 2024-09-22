<?php

namespace App\Http\Controllers;

use App\Models\UpdateHistory;
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
    
}
