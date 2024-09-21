@extends('layout')    <!--共通テンプレート-->

@section('content')

<!--入力内容に不備がある場合、入力内容確認画面に移行せず、内容に応じた警告文が上側に表示される-->
    <!--　管理者判定 -->
    

    <h3>更新履歴編集</h3>
    
    {{ Form::open(['route' => 'pianew.send' , 'onsubmit'=> false]) }}
        @csrf
        <div class='form-group'>
            {{ Form::label('pay_day','支払日　：') }}
            {{ Form::date('pay_day', 'YYYYmmdd')}}
            ※必須入力
        </div>
        <div class='form-group'>
            {{ Form::label('payee','支払先　：') }}
            {{ Form::text('payee',null) }}
            ※必須入力
        </div>
        <div class='form-group'>
            {{ Form::label('accnt_class','科目　　：') }}
            {{ Form::select('accnt_class',$account_items,['selected' => '0']) }}
            ※必須入力
        </div>
        <div class='form-group'>
            {{ Form::label('pay_detail','支払内容：') }}
            {{ Form::text('pay_detail',null) }}
            ※必須入力
        </div>
        <div class='form-group'>
            {{ Form::label('amount','金額　　：') }}
            {{ Form::number('amount',null) }}
            ※必須入力
        </div>
        <div class='form-group'>
            {{ Form::label('rmk','備考　　：') }}
            {{ Form::text('rmk',null) }}
            ※任意入力
        </div>
        
        <div class='form-group'>
            {{ Form::button ('入力',['class' => 'btn btn-outline-primary','onclick' => 'submit()']) }}
        </div>
        
    {{ Form::close() }}
            
    <div>
        <a href={{ route('pia.main') }}>戻る</a>
    </div>
    
@endsection