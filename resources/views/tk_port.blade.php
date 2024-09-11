@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h1>TK_PORTFPLIO</h1>
    
    <br><br>

<!-- 
        <p><a href = {{ route('') }}>自己紹介へ</a></p>  
 -->
        <br>
        <p><a href = {{ route('pia_index.list') }}>家計簿アプリ試作 　へ</a></p>
        
    <br><br>
    
        <p>メインページに戻る</p>        

@endsection