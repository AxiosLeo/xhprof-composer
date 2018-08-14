<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018/8/7 15:32
 */

namespace xhprof\driver;

use tpr\db\Db;
use xhprof\XHProf;
use xhprof\lib\Driver;

class Mongo extends Driver
{
    private $mongo;

    private $options;

    public function __construct()
    {
        $this->options = XHProf::options();
        $mongo_config  = $this->options->get('mongo', []);
        $connect_name  = $this->options->get('mongo.connect_name', 'xhprof_mongo_database');
        $table_name    = $this->options->get('mongo.table', 'xhprof');
        $this->mongo   = Db::connect($mongo_config, $connect_name)->table($table_name);
    }

    public function save($run_id, $data)
    {
        $data = [
            'run_id' => $run_id,
            'data'   => $data
        ];

        $exist = $this->mongo->where('run_id', $run_id)->count();
        if ($exist) {
            $this->mongo->where('run_id', $run_id)->update($data);
        } else {
            $this->mongo->insert($data);
        }
        return $run_id;
    }

    public function get($run_id)
    {
        return $this->mongo->where('run_id', $run_id)->find();
    }
}