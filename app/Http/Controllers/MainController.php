<?php

namespace App\Http\Controllers;

use App\main;
use Auth;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    //メイン画面に移行
    public function main()
    {
        
        //↓説明資料ダウンロードに関する処理
        // 対象ディレクトリ内の「資料 YYYY-MM-DD.docx」に一致するファイルを取得
        $nameparts = glob(storage_path('app/家計簿アプリ説明資料　*.docx'));
        if (!empty($nameparts)) {
            // ファイル名を分離して最新のファイルを取得
            $filename = basename($nameparts[0]);  // 必要に応じて最新のファイルを選択
        } else {
            $filename = null; // ファイルがない場合
        }
        
        return view('main',compact('filename'));
    }
    
    //プロフィール画面に移行
    public function profile()
    {
        return view('profile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\main  $main
     * @return \Illuminate\Http\Response
     */
    public function show(main $main)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\main  $main
     * @return \Illuminate\Http\Response
     */
    public function edit(main $main)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\main  $main
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, main $main)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\main  $main
     * @return \Illuminate\Http\Response
     */
    public function destroy(main $main)
    {
        //
    }
}
