<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018/8/7 15:28
 */

namespace xhprof\lib;

use xhprof\XHProf;

abstract class Driver
{
    private static $instance;

    /**
     * @return mixed
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            $driver = XHProf::options()->get('driver', 'file');
            $driver = "xhprof\\driver\\" . ucfirst(strtolower($driver));

            self::$instance = new $driver();
        }
        return self::$instance;
    }

    protected $options;

    abstract public function save($run_id, $data);

    abstract public function get($run_id);
}