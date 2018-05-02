<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 10:27
 */
namespace xhprof\lib;

class Graph
{
    private $run = '';

    private $source = '';

    private $ext = 'png';

    private $threshold = 0.01;

    private $run_compare1 = '';

    private $run_compare2 = '';

    private $options = [];

    public function __construct(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function setRunId($run_id){
        $this->run = $run_id;
        return $this;
    }

    public function getRunId(){
        return $this->run;
    }

    public function setSource($source){
        $this->source = $source;
        return $this;
    }

    public function getSource(){
        return $this->source;
    }

    public function setFileExt($ext = 'png'){
        $this->ext = $ext;
        return $this;
    }

    public function getFileExt(){
        return $this->ext;
    }

    public function setThreshold($threshold){
        $this->threshold = $threshold;
        return $this;
    }

    public function getThreshold(){
        return $this->threshold;
    }

    public function setDiffRun($run1,$run2){
        $this->run_compare1 = $run1;
        $this->run_compare2 = $run2;
        return $this;
    }

    public function getDiffRun(){
        return [
            'run1'=>$this->run_compare1,
            'run2'=>$this->run_compare2
        ];
    }
}