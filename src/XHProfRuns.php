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

    public static function query(array $options = []){
        return new self($options);
    }

    private $options = [];

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function find($run_id){
        $driver = xhprof_driver($this->options);
        return $driver->get($run_id);
    }

    public function select($run_id_list = []){
        $list = []; $n = 0;
        foreach ($run_id_list as $run_id) {
            $list[$n]['run_id'] = $run_id;
            $list[$n]['data']   = XHProfRuns::query()->find($run_id);
            $n++;
        }

        return $list;
    }
}