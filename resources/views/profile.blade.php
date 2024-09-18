@extends('layout')    <!--共通テンプレート-->

@section('content')

    <h1>profile</h1>
    
    <div>
        <table border="1" style="border-collapse: collapse" class="test-variable-width-table">
            <tr align="center">
                <th>氏名</th>
                <td align="center">加藤　岳史　（カトウ　タケフミ）</td>
            </tr>
            <tr align="center">
                <th>生年月日</th>
                <td> 1979年12月21日 </td>
            </tr>
            <tr>
                <th>
                    希望職種に就くための取り組み</th>
                <td>
                    ●取り組んだこと<br>
                    　○職業訓練校で、プログラミングに関する下記の訓練を以下の通り受講。<br>
                    　（期間：2023年9月～2024年2月）<br>
                    　　・マイクロコンピュータの基礎知識とアセンブリ言語を用いたプログラミング<br>
                    　　・C言語の基礎および組込みプログラミング<br>
                    　　・Java言語の基礎およびWebアプリとAndroidアプリの作成<br>
                    　○関連する資格を取得。<br>
                    　　・基本情報技術者、Oracle<br>
                    　　・Certified Java Programmer, Bronze SE<br>
                    ●現在取り組んでいること<br>
                    　○プログラミング学習サイトにてプログラミングを学習。<br>
                    　○これまで学んだスキルを活かし、WEBプログラムを制作。<br>
                    　○引き続き継続的に学ぶこと。<br>
                </td>
            </tr>
        </table>
    
    </div>
    <br>

    <p><a href = {{ route('main') }}>メインページに戻る</a></p>         


@endsection

