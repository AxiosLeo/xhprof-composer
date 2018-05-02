<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 11:19
 */

namespace xhprof\driver;

abstract class Driver
{
    abstract public function __construct();

    abstract public function save($run_id, $data);

    abstract public function get($run_id);
}