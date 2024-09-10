@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h1>明細照会</h1>

    <h2>{{Auth::user()->name}} さんの明細</h2>
    
    @foreach ($messages as $message)
        <a>{{ $message }}</a>
    @endforeach
    
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
    

    <form action={{ route('piainquiry.csv') }} method="post">
    @csrf                  
        <div style="border-width:thin; border-style:dashed;padding:20px 20px 20px;border-color:#777777;">
            <a>照会結果のCSVデータをダウンロードする場合、"ダウンロード"ボタンをクリックしてください。</a>
            <br>
            <a>※データ名を指定する場合、テキストボックスに入力してください。</a>
            <br>
            {{ Form::text('filename',null) }}
            <a style="font-size: small;">※任意入力</a>
            <input type="button" value="ダウンロード" onClick="submit();">
        </div>
        <br>
    </form>

    <div>
        <a href={{ route('piainquiry.input') }}>戻る</a>
    </div>


@endsection