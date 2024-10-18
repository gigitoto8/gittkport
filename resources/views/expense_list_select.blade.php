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

    <h2>月別出費状況　条件指定</h2>
    <p>年・月基準で期間を指定してください。</p>
    
    <form action={{ route('expense_list.show') }} method="get">
        @csrf
            <div style="border-width:thin; border-style:dashed;padding:0px 20px 20px;border-color:#777777;">
                <table>
                    <tr style="font-size: small;">
                        <td></td>
                        <td>From</td>
                        <td></td>
                        <td>To</td>
                    </tr>
                    <tr>
                        <td>期間　：　</td>
                        <td>{{ Form::month('dayFrom', 'YYYY-mm') }}</td>
                        <td>　~　</td>
                        <td>{{ Form::month('dayTo', 'YYYY-mm') }}</td>
                    </tr>
                </table>
                <div style="font-size: small;">
                    <a>・全期間を照会する場合は入力不要。</a><br>
                    <a>・期間を指定する場合はFromまたはToに入力すること。</a><br>
                    <a>・両方入力する場合、Fromの時期がToの時期より後にならないこと。</a>
                </div>
            </div>
            <br>
            
            <br>
            <input type="button" value="照会" onClick="submit();">
    </form>
    <div>
        <a href={{ route('pia.main') }}>戻る</a>
    </div>
@endsection