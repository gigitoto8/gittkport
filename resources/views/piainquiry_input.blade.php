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

    <h2>明細照会</h2>
    <p>照会したい期間および勘定科目の検索条件を指定してください。</p>
    
    <form action={{ route('piainquiry.confirm') }} method="get">
            <div style="border-width:thin; border-style:dashed;padding:0px 20px 20px;border-color:#777777;">
                <table>
                    <tr style="font-size: small;">
                        <td></td>
                        <td>From</td>
                        <td></td>
                        <td>To</td>
                    </tr>
                    <tr>
                        <td>照会期間　：　</td>
                        <td>{{ Form::date('day_from', 'YYYY-mm-dd') }}</td>
                        <td>　~　</td>
                        <td>{{ Form::date('day_to', 'YYYY-mm-dd') }}</td>
                    </tr>
                </table>
                <div style="font-size: small;">
                        <a>※全期間を照会する場合は入力不要。</a><br>
                        <a>※期間を指定する場合はFromまたはToに入力すること。<br>
                        　両方入力する場合、Fromの日付がToの日付より後にならないこと。</a>
                </div>
            </div>
            <br>
            <div style="border-width:thin; border-style:dashed;padding:20px 20px 20px;0px 20px 20px;border-color:#777777;">
                <td>照会科目　：　</td>
                {{ Form::select('accnt_class',$account_items) }}<br>
                <a style="font-size: small;">※科目を指定しない場合は選択不要。</a><br>
            </div>
            <br>
            <input type="button" value="照会" onClick="submit();">
    </form>
    <div>
        <a href={{ route('pia_index.list') }}>戻る</a>
    </div>
@endsection