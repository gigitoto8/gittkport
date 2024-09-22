@extends('layout')    <!--共通テンプレート-->

@section('content')

<!--入力内容に不備がある場合、入力内容確認画面に移行せず、内容に応じた警告文が上側に表示される-->
    <!--　管理者判定 -->
    

    <h3>更新履歴</h3>
    
    {{ Form::open(['route' => 'uplhis_main' , 'onsubmit'=> false]) }}
        @csrf
        <div class='form-group'>
            {{ Form::label('update_date','支払日　：') }}
            {{ Form::date('update_date', 'YYYYmmdd')}}
            ※必須入力
        </div>
        <div class='form-group'>
            {{ Form::label('detail','内容　：') }}
            {{ Form::text('detail',null) }}
            ※必須入力
        </div>
        
    {{ Form::close() }}
            
    <div>
        <a href={{ route('uplhis.main') }}>戻る</a>
    </div>
    
@endsection