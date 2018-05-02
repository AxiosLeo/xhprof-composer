# xhprof-composer
> composer library for xhprof

## Install

```shell
composer require axios/xhprof-composer
```

## Example

```shell

namespace xhprof;

require_once __DIR__.'/../vendor/autoload.php';

XHProfDebug::start();

/*** begin ***/

dump('this is example for use xhprof-composer');
$a = pow(2,10);
dump($a);

/*** end ***/

$runs = XHProfDebug::end();

dump($runs->getData());

```