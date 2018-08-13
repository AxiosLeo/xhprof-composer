<?php
/**
 * @author: axios
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 11:08
 */

namespace xhprof\driver;

use xhprof\XHProf;
use xhprof\XHProfDriver;

class File extends XHProfDriver
{
    protected $dir = '';

    public function __construct()
    {
        $dir = ini_get("xhprof.output_dir");
        if(empty($dir)){
            $dir = '/tmp/xhprof';
        }
        XHProf::options()->get('file.output_dir', $dir);
        if (!file_exists($dir)) {dump($dir);
            mkdir($dir, 0777);
        }
        $this->dir = $dir;
    }

    public function save($run_id, $data)
    {
        $xhprof_data = serialize($data);
        $file_name   = $this->fileName($run_id);

        $file = fopen($file_name, 'w');

        if ($file) {
            fwrite($file, $xhprof_data);
            fclose($file);
        }
        return $run_id;
    }

    public function get($run_id)
    {
        $file_name = $this->fileName($run_id);
        if (!file_exists($file_name)) {
            return null;
        }

        return unserialize(file_get_contents($file_name));
    }

    private function fileName($run_id)
    {

        $filename = "_" . $run_id . ".xhprof_log";
        return $this->dir . "/" . $filename;
    }
}