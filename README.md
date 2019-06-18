# TimeAttack

## 基本的な使い方

```php
<?php
use muramoya\DevTools\TimeAttack;

// 計測スタート
echo TimeAttack::start(true); // 区間タイムを測定したいときは引数にtrueを指定します。

// 区間タイム測定
// TimeAttack::start(true)の時 → start - splitまでの計測時間とsplit-split間の区間タイムを表示します。
// TimeAttack::start(false)の時 → start - splitまでの計測時間のみ表示します。
// 引数に文字列を指定することで区間のラベルを設定することができます。
echo TimeAttack::split('label');

//計測終了
echo TimeAttack::finish();

// TimeAttack::start() TimeAttack::split() TimeAttack::finish()それぞれのメソッドは計測値を返します。
```

## 結果をファイルに出力する

ファイル出力を有効にすることで計測メソッドが計測値を返しつつファイルに計測値を書き込むことができます。

```php
<?php
use muramoya\DevTools\TimeAttack;

// ファイル出力を有効にする
// TimeAttack::start()の前に呼び出してください。
// TimeAttack::enableFileOutput(出力ファイルパス, ログフォーマット(monolog準拠), ログ名(monolog準拠));
// 出力ファイルのデフォルトは/tmp/timeattack.logです。
// ログフォーマットのデフォルトは[%datetime%] [%channel%] %message%\nです。
// ログ名のデフォルトはnullです。
TimeAttack::enableFileOutput('/path/to/log', '[%file_format%]', 'logName');

// ログレベルを変更する場合はTimeAttack::setLogLevel()を呼び出します。
// TimeAttack::enableFileOutputの後に呼び出してください。
// デフォルトはinfoです。
TimeAttack::setLogLevel('warn');

// 計測スタート
echo TimeAttack::start(true);

echo TimeAttack::split('label');

//計測終了
echo TimeAttack::finish();
```

## その他

```php
// 計測値の小数点以下の桁数を指定します。これはround()の第3引数に相当します。デフォルトは2です。
TimeAttack::changeRoundPrecision(3)
```