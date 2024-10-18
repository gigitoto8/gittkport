@extends('layout')    <!--共通テンプレート-->

@section('custom_styles')
    <style>
        /* ここに特定のCSSを記述 */
            .listShow{
                width: 120%;    /* 全体幅を親要素に合わせる */
                max-height: 700px;
                overflow-y: auto;
                margin-left: auto; /* 左右の余白を自動にして中央に配置 */
                margin-right: auto;
                box-sizing: border-box; /* パディングやボーダーを幅に含める */
            }
            table {
                width: auto;
                min-width: 780px; /* 最小幅を設定して、両端が表示されるようにする */
                border-collapse: collapse; /* 余計な余白をなくす */
                margin: 0 auto; /* 左右の余白を自動で均等にして中央に寄せる */
            }
            th, td {
                border: 1px solid #777;
                padding: 8px;
                text-align: right;
                overflow: hidden; /* 内容がはみ出るのを防ぐ */
                text-overflow: ellipsis; /* はみ出るテキストを「…」にする */
                white-space: nowrap; /* 改行をさせず、1行で表示 */
            }
            td {
                border: 1px solid #777;
                padding: 8px;
                text-align: right;
                font-size: 12px; /* フォントサイズを小さく設定 */
                overflow: hidden; /* 内容がはみ出るのを防ぐ */
                text-overflow: ellipsis; /* はみ出るテキストを「…」にする */
                white-space: nowrap; /* 改行をさせず、1行で表示 */
            }
            th:first-child, td:first-child {
                width: 100px; /* 左端の列の幅を指定 */
            }
            th:last-child, td:last-child {
                width: 120px; /* 右端の列の幅を指定 */
            }
            th.fixed01{
                writing-mode: vertical-lr;
                text-align: center; /* 横方向の中央揃え */
                vertical-align: middle; /* 縦方向の中央揃え */
                position: sticky;
                top: 0;
                color: #fff;
                background: #333;
                height: 150px; /* 高さを指定して、スペースを確保 */
                /* 必要に応じてフォントサイズや色を設定 */
                font-size: 20px;
                width: 80px; /* 縦書き列の幅を固定 */
            }
        }
    </style>
@endsection

@section('content')

    {{print_r($oldestDate)}}
    {{print_r($newestDate)}}
    
    <h1>月別支払状況</h1>

    <h2>{{Auth::user()->name}} さんの支払</h2>
    
    <div class='listShow'>
        <table class='table table-striped table-hover'>
            <!-- 年月を表示する行 -->
            <thead>
                <tr>
                    <th class="fixed01">年-月</th>
                    @foreach ($accnt_classes as $accnt_class)
                        <th class="fixed01">{{ $accnt_class }}</th>
                    @endforeach
                    <th class="fixed01">合計</th>
                </tr>
            </thead>
            <tbody>
                <!-- データ行：月ごとのデータを表示 -->
                @foreach($months as $month)
                    <tr>
                        <td>{{ $month }}</td>
                        <!-- 行の金額を加算し保管する変数 -->
                        @php
                            $columnTotal = 0; 
                        @endphp
                        <!-- 月別出費小計を表示 -->
                        @foreach($accnt_classes as $accnt_class)
                            <td>{{ number_format($data[$month][$accnt_class] ?? 0)}}</td>
                            @php
                                $columnTotal += $data[$month][$accnt_class];
                            @endphp
                        @endforeach
                        <!-- 月別出費合計を表示 -->
                        <td>{{ number_format($columnTotal) }}</td>
                    </tr>
                @endforeach
                <!-- 科目別出費平均額を表示する行 -->
                <tr>
                    <td>平均</th>
                    <!-- 平均額を表示 -->
                    @foreach($accnt_classes as $accnt_class)
                        <td>{{ number_format($totals[$accnt_class]/count($months)) }}</th>
                    @endforeach    
                    <!-- 平均額を表示 -->
                    <td>{{ number_format((array_sum($totals))/count($months)) }}</th></th>    
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <a href={{ route('expense_list.select') }}>戻る</a>
    </div>

@endsection