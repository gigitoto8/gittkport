@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h1>{{ $message }}</h1>
    <br>
    <a href={{ route('pianew.input') }}>入力を続ける</a>
    <br><br>
    <a href={{ route('pia.main') }}>家計簿アプリ　メインページに戻る</a>
    
@endsection