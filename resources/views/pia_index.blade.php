@extends('layout')    <!--共通テンプレート-->

@section('content')


    <h1>家計簿アプリ　試作版</h1>
    
    <br><br>
    
    @if(Auth::id() == null)
        <!-- ログインしていない場合に表示。 -->
        <p>ようこそ　ゲスト　さん</p>
        <br>
        <p><a href = {{route('home')}}>ログイン</a>をお願いします。</p>
        
    @else
        <!-- ログインしている場合に表示 -->
        
        <p>ようこそ {{Auth::user()->name}} さん</p>    
        <br>
        <p><a href = {{ route('pianew.input') }}>入力画面</a></p>
        <br>
        <p><a href = {{ route('pia.show') }}>照会画面</a></p>  
        
    @endif
    
    <br>
    <br>
    
        <p>メインページに戻る</p>        

@endsection