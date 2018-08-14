<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018/8/7 15:32
 */

namespace xhprof\driver;

use Predis\Client;
use xhprof\XHProf;
use xhprof\lib\Driver;

class Redis extends Driver
{
    private $redis;

    private $options;

    private $redis_config;

    public function __construct()
    {
        $this->options      = XHProf::options();
        $this->redis_config = $this->options->get('redis', [
            'hash_table' => 'xhprof_log',
            'scheme'     => 'tcp',
            'host'       => '127.0.0.1',
            'port'       => 6379,
        ]);
        $this->redis        = new Client($this->redis_config);
    }

    public function save($run_id, $data)
    {
        $data = [
            'run_id' => $run_id,
            'data'   => $data
        ];

        $this->redis->hset($this->redis_config['hash_table'], $run_id, json_encode($data));
        return $run_id;
    }

    public function get($run_id)
    {
        $data = $this->redis->hget($this->redis_config['hash_table'], $run_id);
        $data = json_decode($data, true);
        return $data;
    }
}