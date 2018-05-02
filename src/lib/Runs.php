<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 13:28
 */

namespace xhprof\lib;


use xhprof\driver\Driver;

class Runs
{
    protected $driver;

    protected $driverList = [
        'file', 'mongo', 'redis'
    ];

    protected $name = 'xhprof';

    protected $options = [
        'driver' => 'file'
    ];

    /**
     * @var Driver
     */
    protected $driverObj;

    protected $run_id = null;

    public function __construct(array $options, $name)
    {
        $this->options = array_merge($this->options, $options);
        $this->name = $name;

        $driver = strtolower($this->options['driver']);
        if (!in_array($driver, $this->driverList)) {
            $driver = 'file';
        }

        $driver = "xhprof\\driver\\" . ucfirst($driver);

        $this->driverObj = new $driver($this->options);
    }

    public function getData()
    {
        return $this->driverObj->get($this->run_id);
    }

    public function saveData(array $xhprof_data)
    {
        if ($this->run_id === null) {
            $this->run_id = $this->makeRunId($this->name);
        }

        $this->driverObj->save($this->run_id, $xhprof_data);

        return $this->run_id;
    }

    private function makeRunId($salt)
    {
        return md5($salt . uniqid(md5(microtime(true)), true));
    }
}