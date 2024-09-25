@extends('layout')    <!--共通テンプレート-->

@section('custom_styles')
    <style>
        /* ここに特定のCSSを記述 */
        .upd_box {
            max-height: 200px !important; /* 高さを小さくする */
            overflow-y: auto; /* 縦のスクロールバーを表示 */
            border: 1px solid #ccc; /* ボックスの枠線 */
            padding: 10px; /* 内側の余白 */
            background-color: #f9f9f9; /* 背景色 */
            line-height: 1.5; /* 行の高さ */
        }
    </style>
@endsection

@section('content')

<!--入力内容に不備がある場合、入力内容確認画面に移行せず、内容に応じた警告文が上側に表示される-->
    <!--　管理者判定 -->
    

    <h3>更新履歴編集</h3>
    
    <table class="upd_box">
        <tr>
            <th width="80" class="sticky">チェック</th>
            <th width="40">ID</th>
            <th width="80">更新日</th>
            <th width="150">内容</th>
            <th width="150">備考</th>
        </tr>
        @foreach ($re_his as $history)
            <tr>
                <td>
                <td>{{ $history->id }}</td>
                <td>{{ date('Y/m/d',strtotime($history->update_date)) }}</td>
                <td>{{ $history->detail }}</td>
                <td>{{ $history->rmk }}</td>
            </tr>
            
        @endforeach
    </table> 

    
    <div>
        <a href={{ route('updhis.input') }}>入力する</a>
    </div>

    <div>
        <a href={{ route('pia.main') }}>戻る</a>
    </div>
    
@endsection