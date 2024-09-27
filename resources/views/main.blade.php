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

    <h1>ポートフォリオ</h1>
    
    <br>
    

    
    <br><br>
        
        @if(Auth::id() == null)
            <!-- ログアウト時に表示。 -->
            <p>ようこそ　ゲスト　さん</p>
            <br>
            <p><a href = {{route('home')}}>ログイン</a>をお願いします。</p>
            
        @else
            <!-- ログイン時に表示 -->

            <h2>ようこそ {{Auth::user()->name}} さん</h2>
            <br>
            <br>                        
            
            <!-- 更新履歴表示 -->
            <a>更新履歴</a>
            <div class="upd_box">
                <table>
                    <thead>
                        <tr>
                            <th class="fixed01">更新日</th>
                            <th class="fixed01">内容</th>
                            <th class="fixed01">備考</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($re_his as $history)
                        <tr>
                            <td>{{ date('Y/m/d',strtotime($history->update_date)) }}</td>
                            <td>{{ $history->detail }}</td>
                            <td>{{ $history->rmk }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table> 
            </div>
            
            <br>
            <br>
            <!--
            <br>
            <p><a href = {{ route('profile') }}>自己紹介へ</a></p>
            -->
            <br>
            @if($filename)
                <a href="{{ url('/download/' . $filename) }}">アプリ説明資料をダウンロード</a>
            @else
                <p>ダウンロード可能なファイルがありません。</p>
            @endif
            <br>
            <br>
            <p><a href = {{ route('pia.main') }}>家計簿アプリ（試作版）へ</a></p>
            <br>
            
        @endif
    

@endsection