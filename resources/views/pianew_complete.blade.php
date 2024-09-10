@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h1>{{ $message }}</h1>
    <br>
    <a href={{ route('pianew.input') }}>入力を続ける</a>
    <br><br>
    <a href={{ route('pia_index.list') }}>インデックス画面に戻る</a>
    
@endsection