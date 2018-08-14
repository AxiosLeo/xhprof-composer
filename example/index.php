<?php
/**
 * @author: axios
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 13:50
 */

namespace xhprof;

require_once __DIR__ . '/../vendor/autoload.php';

XHProf::start();

/*** begin ***/

dump('this is example for use xhprof-composer');
$a = pow(2, 10);
dump($a);

/*** end ***/

$report = XHProf::end('test');
dump($report);
$run_id = XHProf::getRunId('test');


// Query Data
dump($run_id);
dump(XHProfRuns::query()->find($run_id));

$list = [
    '38cece5b1ce049e446b5f58fba0aba7c',
    '86cd5712d2a679efe80c743d1d2342e8',
    '773a5a2a3a50ebf16fa0dc5256cafd46'
];

$data = XHProfRuns::query()->select($list);
dump($data);


$report = XHProf::report($run_id);

dump($report->getTotalCpuTime());
dump($report->getTotalMemory());
dump($report->getList());
dump($report->getTree());