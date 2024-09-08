@extends('layout')    <!--共通テンプレート-->

@section('content')

<!--入力内容に不備がある場合、警告文が表示され、ページ遷移しない-->
    @if ($errors->any())
    <div style="color:red;">
    <ul>
    	@foreach ($errors -> all() as $error)
    	<li>{{ $error }}</li>
    	@endforeach
    </ul>
    </div>
    @endif

    <h1>明細入力</h1>
    
    {{ Form::open(['route' => 'pianew.send' , 'onsubmit'=> false]) }}

        <div class='form-group'>
            {{ Form::label('pay_day','支払日:') }}
            {{ Form::date('pay_day', 'YYYYmmdd')}}
        </div>
        <div class='form-group'>
            {{ Form::label('payee','支払先:') }}
            {{ Form::text('payee',null) }}
        </div>
        <div class='form-group'>
            {{ Form::label('accnt_class','勘定科目：') }}
            {{ Form::select('accnt_class',$account_items) }}
        </div>
        <div class='form-group'>
            {{ Form::label('pay_detail','支払内容：') }}
            {{ Form::text('pay_detail',null) }}
        </div>
        <div class='form-group'>
            {{ Form::label('amount','金額：') }}
            {{ Form::number('amount',null) }}
        </div>
        <div class='form-group'>
            {{ Form::label('rmk','備考：') }}
            {{ Form::text('rmk',null) }}
        </div>
        <!-- 後程、5レコード挿入できるよう修正 -->
        <div class='form-group'>
            {{ Form::button ('入力',['class' => 'btn btn-outline-primary','onclick' => 'submit()']) }}
        </div>
        
    {{ Form::close() }}
            
    <div>
        <a href={{ route('pia_index.list') }}>戻る</a>
    </div>
    
@endsection