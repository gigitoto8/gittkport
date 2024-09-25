@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h3>更新履歴</h3>
    
    {{ Form::open(['route' => 'updhis.store' , 'onsubmit'=> false]) }}
        @csrf
        <div class='form-group'>
            {{ Form::label('update_date','更新日　：') }}
            {{ Form::date('update_date', 'YYYYmmdd')}}
            ※必須入力
        </div>
        <div class='form-group'>
            {{ Form::label('detail','内容　　：') }}
            {{ Form::text('detail',null) }}
            ※必須入力
        </div>
        <div class='form-group'>
            {{ Form::label('rmk','備考　　：') }}
            {{ Form::text('rmk',null) }}
            ※任意入力
        </div>
        <input type="button" value="入力" onClick="submit();">
    {{ Form::close() }}
            
    <div>
        <a href={{ route('updhis.main') }}>戻る</a>
    </div>
    
@endsection