@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h1>明細照会</h1>

    <h2>{{Auth::user()->name}} さんの明細</h2>
    
    <a>
        検索条件　　
        @if($inputs2['day_from'] == '0000-01-01' && $inputs2['day_to'] == '9999-12-31')
            <a>期間：全期間</a>
        @elseif($inputs2['day_to'] == '9999-12-31')
            <a>期間：{{ date($inputs2['day_from']) }} から</a>
        @elseif($inputs2['day_from'] == '0000-01-01')
            <a>期間：{{ date($inputs2['day_to']) }} まで</a>
        @else
            <a>期間：{{ date($inputs2['day_from']) }} から {{ date($inputs2['day_to']) }} まで</a>
        @endif
        <a>|</a>
        @if(isset($inputs2['accnt_class']))
            <a>科目：{{ $inputs2['accnt_class'] }}</a>
        @else
            <a>科目：全科目</a>
        @endif
    </a>

    <table class='table table-striped table-hover'>
        <tr>
            <th>明細管理番号</th>
            <th>支払日</th>
            <th>支払先</th>
            <th>科目</th>
            <th>内容</th>
            <th>金額（税込）</th>
            <th>備考</th>
            <th>ユーザーID</th>
            <th>登録日</th>
            <th>更新日</th>
        </tr>
        @foreach ($pay_infos10 as $pay_info)
            <tr>
                <td>{{ str_pad($pay_info->id, 5, 0, STR_PAD_LEFT) }}</td>           <!-- zerofill表示 -->
                <td>{{ $pay_info->pay_day }}</td>
                <td>{{ $pay_info->payee }}</td>
                <td>{{ $pay_info->accnt_class }}</td>
                <td>{{ $pay_info->pay_detail }}</td>
                <td align=rigth>{{ number_format($pay_info->amount) }}  円</td>     <!--金額　桁区切り-->
                <td>{{ $pay_info->rmk }}</td>
                <td>{{ str_pad($pay_info->user_id, 5, 0, STR_PAD_LEFT) }}</td>      <!-- zerofill表示 -->
                <td>{{ $pay_info->created_at }}</td>
                <td>{{ $pay_info->updated_at }}</td>
            </tr>
        @endforeach
                <!-- 関連付けカラムは、shop変数に続けて、category-.nameと記述 -->
    </table> 

    {{ $pay_infos10->appends(request()->input() )->links() }}
    

    <form action={{ route('pia.crecsv') }} method="post">
    @csrf                  
        <div style="border-width:thin; border-style:dashed;padding:20px 20px 20px;border-color:#777777;">
            <a>照会結果のCSVデータをダウンロードする場合、"CSVダウンロード"ボタンをクリックしてください。</a>
            <br>
            <a>※データ名を指定する場合、テキストボックスに入力してください。</a>
            <br>
            {{ Form::text('filename',null) }}
            <input type="button" value="CSVダウンロード" onClick="submit();">
        </div>
        <br>
    </form>

    <div>
        <a href={{ route('pia.show') }}>戻る</a>
    </div>


@endsection