# gittkport  

## gittkportについて  

1.  
　これまでに得たスキルをアウトプットするため、ポートフォリオの制作に取り組みました。
　また、github活用のため、本リポジトリを作成しました。  
2.アプリ概要
　・家計の支出を記録するアプリ。
　・機能は、支払情報記録と支出明細照会の２種類。
　・照会した明細はCSV形式のファイルでダウンロードが可能。
    ※一部のユーザーのみに対しアプリURLを公開しています。

３．開発環境および選定理由
　・インフラ　　　　：　PaizaCloud（Webサーバ、DBサーバ、エディタ）
　・技術　　　　　　：　PHP 7.4.1 ,Laravel Framework 6.20.26 , MySQL 14.14 ,Bootstrap 4.0.0
　・主要パッケージ　：　Laravel ui 1.3.0 , Lravel Collective html 6.4.1
  ・その他　　　　　：　PHPMyAdmin 5.0.1 , Composer 1.9.2
  ・技術選定理由　　：　PHPとLaravelは、現時点で需要が高い技術の一つに挙げられているため、
  　　　　　　　　　　　身に付けることで採用において有利になると考えました。
                    　インフラについては、構築の経験が皆無でしたが、インフラがある程度整ってい
                    　るPaizaCloudの存在を知り、未経験でも手軽に設定ができると考え、PaizaCloud
                    　を選定しました。

４．機能説明
    ○支払情報入力
    1 支払情報入力画面
    フォームに各項目を入力。科目はセレクトボックスから科目（accnt_itemsテーブルから抽出した文
    字列）を選択する。
    “入力ボタン”を押すと、バリデーションが行われる。入力に不備があると、画面上側に不備に応じた
    警告文が表示される。入力に問題がなければ入力情報確認に移行する。
    2 入力情報確認
    表示される入力情報を確認する。内容に問題がなければ”登録”ボタンを押す。その直後、入力情報
    がデータベースに登録され、そのまま支払情報入力に移行する。
    ”やり直す”ボタンを押すと、入力値を保持したまま支払情報入力に戻る。
    ○明細照会
    1 明細照会条件指定
    照会期間の入力と勘定科目の選択により照会条件を指定する。指定後、照会ボタンを押すと、指定
    条件と登録ユーザーidを基にpay_infosテーブルからレコードを抽出し、明細照会に移行する。
    2 明細照会
    ページング機能により、1ページにつき10件のレコードが表示される。
    明細データを入手したい場合、画面下側にあるフォームの”ダウンロード”ボタンを押すことで、
    CSV形式のファイルをダウンロードすることが可能。
    


The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
