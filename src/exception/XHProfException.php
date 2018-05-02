<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 11:30
 */

namespace xhprof\exception;

class XHProfException extends \Exception
{
    protected $data = [];

    final protected function setData($label, array $data)
    {
        $this->data[$label] = $data;
    }

    final public function getData()
    {
        return $this->data;
    }
}