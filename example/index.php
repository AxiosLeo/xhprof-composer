<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 13:50
 */

namespace xhprof;

require_once __DIR__.'/../vendor/autoload.php';

XHProfDebug::start();
dump('this is example for use xhprof-composer');
$a = pow(2,10);
dump($a);
$runs = XHProfDebug::end();
dump($runs->getData());