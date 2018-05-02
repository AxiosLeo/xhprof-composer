<?php

namespace xhprof;

use xhprof\lib\Runs;

class XHProfRuns
{
    protected static $instance = [];

    /**
     * @param array $options
     * @param string $name
     * @return Runs
     */
    public static function instance($name = 'xhprof', array $options = []): Runs
    {
        self::$instance[$name] = new Runs($options, $name);
        return self::$instance[$name];
    }

    public static function find($run_id){

    }

    public static function all($page = 1, $limit = 100){

    }
}