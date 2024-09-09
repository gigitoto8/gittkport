@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h1>家計簿アプリ　試作版</h1>
    <h2>家計簿アプリ　試作版</h2>

    
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
        <p><a href = {{ route('pianew.input') }}>支払情報入力</a></p>
        <br>
        <p><a href = {{ route('piainquiry.input') }}>支払情報照会</a></p>  
        
    @endif
    
    <br>
    <br>
    
        <p>メインページに戻る</p>        

@endsection