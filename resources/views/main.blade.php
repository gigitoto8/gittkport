@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h1></h1>
    
    <br><br>
        
        @if(Auth::id() == null)
            <!-- ログアウト時に表示。 -->
            <p>ようこそ　ゲスト　さん</p>
            <br>
            <p><a href = {{route('home')}}>ログイン</a>をお願いします。</p>
            
        @else
            <!-- ログイン時に表示 -->
            <p>ようこそ {{Auth::user()->name}} さん</p>
            <br>
            <p><a href = {{ route('profile') }}>自己紹介へ</a></p>
            <br>
            <a href="{{ url('/download/tkport_manual.docx') }}">ポートフォリオ説明書ダウンロードする</a>
            <br>
            <br>
            <p><a href = {{ route('pia_index.list') }}>家計簿アプリ（試作版）へ</a></p>
            <br>
            
        @endif
    

@endsection