@extends('layout')    <!--共通テンプレート-->

@section('custom_styles')
    <style>
        /* ここに特定のCSSを記述 */
            .upd_box {
                width: 100%; /* 必要に応じてサイズを調整 */
                max-height: 200px; /* 必要に応じて高さを指定 */
                overflow-x: auto; /* 横スクロールを有効に */
                overflow-y: auto; /* 縦スクロールを有効に */
                box-sizing: border-box; /* この行を追加 */
            }
            table {
                width: 100%; /* テーブルの幅を全体に広げる */
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #777;
                padding: 8px;
                text-align: left;
            }
            .fixed01{
                position: sticky;
                top: 0;
                color: #fff;
                background: #333;
                &:before{
                content: "";
                position: absolute;
                top: -1px;
                left: -1px;
                width: 100%;
                height: 100%;
            }
        }
    </style>
@endsection

@section('content')

<!--入力内容に不備がある場合、入力内容確認画面に移行せず、内容に応じた警告文が上側に表示される-->
    <!--　管理者判定 -->
    

    <h3>更新履歴編集</h3>
    
    <div class="upd_box">
        <table>
            <thead>
                <tr>
                    <th class="fixed01">チェック</th>
                    <th class="fixed01">ID</th>
                    <th class="fixed01">更新日</th>
                    <th class="fixed01">内容</th>
                    <th class="fixed01">備考</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($re_his as $history)
                <tr>
                    <td></td>
                    <td>{{ $history->id }}</td>
                    <td>{{ date('Y/m/d',strtotime($history->update_date)) }}</td>
                    <td>{{ $history->detail }}</td>
                    <td>{{ $history->rmk }}</td>
                </tr>
                @endforeach
            </tbody>
        </table> 
    </div>

    
    <div>
        <a href={{ route('updhis.input') }}>入力する</a>
    </div>

    <div>
        <a href={{ route('pia.main') }}>戻る</a>
    </div>
    
@endsection