# TimeAttack 使い方

```php
<?php

//[optional]log_name
//[optional]/log/path/hoge.log(default /tmp/timeattack.log)
$timeAttack = new \DevTools\TimeAttack('log_name', '/log/path');

//計測スタート
$timeAttack->start(true);

...
//区間タイム測定
//$timeAttack->start(true)の時 → start - splitまでの計測時間とsplit-split間の区間タイムを表示
//$timeAttack->start(false)の時 → start - splitまでの計測時間のみ表示
//[optional] label
$timeAttack->split('label');

...
//計測終了
$timeAttack->finish();
```
