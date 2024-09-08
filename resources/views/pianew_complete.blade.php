@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h1>{{ $message }}</h1>
    
    <a href={{ route('pianew.input') }}>入力を続ける</a>
    <br>
    <a href={{ route('pia_index.list') }}>戻る</a>
    
@endsection