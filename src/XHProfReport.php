<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 10:09
 */
namespace xhprof;

use xhprof\lib\Compute;
use xhprof\lib\Graph;
use xhprof\lib\GraphRender;
use xhprof\lib\Report;

class XHProfReport
{
    public static function options(array $options = []){
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

        GraphRender::image($Graph)
            ->create();
    }

    public function graphDiff($run1,$run2,$source = 'xhprof' , $file_ext = 'png' , $threshold = 0.01){
        $Graph = new Graph($this->options);
        $Graph->setDiffRun($run1,$run2)
            ->setSource($source)
            ->setFileExt($file_ext)
            ->setThreshold($threshold);


    }

    /**
     * @param $run_id
     * @return Report
     */
    public function report($run_id){
        $rows = XHProfRuns::query()->find($run_id);
        $list = Compute::format($rows);
        $tree = Compute::infiniteTree($list);
        $root = $tree[0];
        xhprof_compute_info($tree, $root['data']['wt'], $root['data']['mu'], $root['data']['cpu']);

        $report = new Report([
            'total_wall_time' => $root['data']['wt'],
            'total_memory'    => $root['data']['mu'],
            'total_cpu_time'  => $root['data']['cpu'],
            'list' => $list,
            'tree' => $tree
        ]);
        return $report;
    }
}