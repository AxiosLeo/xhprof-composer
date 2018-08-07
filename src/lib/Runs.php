<?php
/**
 * @author: axios
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 13:28
 */

namespace xhprof\lib;

use xhprof\XHProfDriver;

class Runs
{
    protected $name = 'xhprof';

    /**
     * @var XHProfDriver
     */
    protected $driver;

    protected $run_id = null;

    public function __construct($name)
    {
        $this->name   = $name;
        $this->driver = XHProfDriver::instance();
    }

    public function getData()
    {
        return $this->driver->get($this->run_id);
    }

    public function getRunId()
    {
        return $this->run_id;
    }

    public function saveData(array $xhprof_data)
    {
        if ($this->run_id === null) {
            $this->run_id = $this->makeRunId($this->name);
        }

        $this->driver->save($this->run_id, $xhprof_data);

        return $this->run_id;
    }

    private function makeRunId($salt)
    {
        return md5($salt . uniqid(md5(microtime(true)), true));
    }
}