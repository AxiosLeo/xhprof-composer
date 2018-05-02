<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 10:09
 */
namespace xhprof;

use xhprof\lib\Graph;

class XHProfReport
{
    public static function options(array $options){
        return new self($options);
    }

    protected $options = [
        'driver'=>'file'
    ];

    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options,$options);
    }

    public function graphSingle($run_id, $source = 'xhprof' , $file_ext = 'png' , $threshold = 0.01){
        $Graph = new Graph($this->options);
        $Graph->setRunId($run_id)
            ->setSource($source)
            ->setFileExt($file_ext)
            ->setThreshold($threshold);
    }

    public function graphDiff($run1,$run2,$source = 'xhprof' , $file_ext = 'png' , $threshold = 0.01){
        $Graph = new Graph($this->options);
        $Graph->setDiffRun($run1,$run2)
            ->setSource($source)
            ->setFileExt($file_ext)
            ->setThreshold($threshold);


    }

    public function report(){

    }
}