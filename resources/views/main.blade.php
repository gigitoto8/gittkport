@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h1>ポートフォリオ</h1>
    
    <br>
    
    <div>
        <a>更新履歴</a>
        <table border="1" style="border-collapse: collapse" class="test-variable-width-table">
            <tr align="center">
                <th>日付</th>
                <th>詳細</th>
            </tr>
            <tr>
                <td valign="top">2024/9/19</td>
                <td> 公開開始 </td>
            </tr>
        </table>
    
    </div>
    
    <br><br>
        
        @if(Auth::id() == null)
            <!-- ログアウト時に表示。 -->
            <p>ようこそ　ゲスト　さん</p>
            <br>
            <p><a href = {{route('home')}}>ログイン</a>をお願いします。</p>
            
        @else
            <!-- ログイン時に表示 -->
            <p>ようこそ {{Auth::user()->name}} さん</p>
            <!--
            <br>
            <p><a href = {{ route('profile') }}>自己紹介へ</a></p>
            -->
            <br>
            <a href="{{ url('/download/家計簿アプリ説明資料　2024-09-19.docx') }}">アプリ説明資料をダウンロードする</a>
            <br>
            <br>
            <p><a href = {{ route('pia.main') }}>家計簿アプリ（試作版）へ</a></p>
            <br>
            
        @endif
    

@endsection