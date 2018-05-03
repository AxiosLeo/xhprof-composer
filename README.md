# xhprof-composer
> composer library for xhprof

## Install

```shell
composer require axios/xhprof-composer
```

## Use

* create record of xhprof_runs 
```php

namespace xhprof;

require_once __DIR__.'/../vendor/autoload.php';

XHProfDebug::start();

/*** begin ***/

dump('this is example for use xhprof-composer');
$a = pow(2,10);
dump($a);

/*** end ***/

$runs = XHProfDebug::end();
$run_id = $runs->getRunId();
dump($run_id);

```

* query 
```php
dump(XHProfRuns::query()->find($run_id));

$list = [
    '38cece5b1ce049e446b5f58fba0aba7c',
    '86cd5712d2a679efe80c743d1d2342e8',
    '773a5a2a3a50ebf16fa0dc5256cafd46'
];

$data = XHProfRuns::query()->select($list);
dump($data);

```

* get report

```php
$report = XHProfReport::options()->report($run_id);

dump($report->getTotalCpuTime());
dump($report->getTotalMemory());
dump($report->getList());
dump($report->getTree());
```