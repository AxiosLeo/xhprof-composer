<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/3 10:58
 */

namespace xhprof\lib;


class Report
{
    private $total_wall_time = 0;

    private $total_memory = 0;

    private $total_cpu_time = 0;

    private $list = [];

    private $tree = [];

    private $run_data = [];

    public function __construct($run_data)
    {
        $this->total_wall_time = $run_data['total_wall_time'];
        $this->total_memory    = $run_data['total_memory'];
        $this->total_cpu_time  = $run_data['total_cpu_time'];
        $this->list = $run_data['list'];
        $this->tree = $run_data['tree'];
        $this->run_data = $run_data;
    }

    public function getTotalWallTime($format = true){
        return $format ? xhprof_time_format($this->total_wall_time) : $this->total_wall_time;
    }

    public function getTotalMemory($format = true){
        return $format ? xhprof_byte($this->total_memory) : $this->total_memory;
    }

    public function getTotalCpuTime($format = true){
        return $format ? xhprof_time_format($this->total_cpu_time) : $this->total_cpu_time;
    }

    public function getList(){
        return $this->list;
    }

    public function getTree(){
        return $this->tree;
    }

    public function data(){
        return $this->run_data;
    }
}