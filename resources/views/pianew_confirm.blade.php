@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h1>入力内容確認</h1>
    <a>以下の内容でよろしいですか？</a>
    {{ Form::open(['route' => 'pianew.store' , 'onsubmit'=> false]) }}
        
        <div class='form-group'>
            {{ Form::label('pay_day','支払日　：') }}
            {{ $input['pay_day'] }}
        </div>
        <div class='form-group'>
            {{ Form::label('payee','支払先　：') }}
            {{ $input['payee'] }}
        </div>
        <div class='form-group'>
            {{ Form::label('accnt_class','科目　　：') }}
            {{ $input['accnt_class'] }}
        </div>
        <div class='form-group'>
            {{ Form::label('pay_detail','支払内容：') }}
            {{ $input['pay_detail'] }}
        </div>
        <div class='form-group'>
            {{ Form::label('amount','金額　　：') }}
            {{ $input['amount'] }}
        </div>
        <div class='form-group'>
            {{ Form::label('rmk','備考　　：') }}
            @if(isset($input['rmk']))
                {{ $input['rmk'] }}    
            @else
                {{ 'ー' }}
            @endif
        </div>
        <div class='form-group'>
            {{ Form::button ('やり直す',['class' => 'btn btn-outline-primary','onclick' => 'history.back()']) }}
        </div>
        <div class='form-group'>
            {{ Form::button ('登録',['class' => 'btn btn-outline-primary','onclick' => 'submit()']) }}
        </div>
        
    {{ Form::close() }}
            
    <div>
        <a href={{ route('pia_index.list') }}>戻る</a>
    </div>
    
@endsection