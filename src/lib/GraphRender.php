<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 14:31
 */

namespace xhprof\lib;


use xhprof\XHProfRuns;

class GraphRender
{
    public static function image(Graph $Graph){
        $run_id = $Graph->getRunId();
        $run_data = XHProfRuns::query()->find($run_id);

        return new self($run_data);
    }

    private $image;

    private $rows;

    protected function __construct($rows)
    {
        $image = imagecreate(400,600);
        $this->image = $image;
        $this->rows  = $rows;
    }

    public function create($background = [255,255,255]){
        imagecolorallocate($this->image,$background[0],$background[1],$background[2]);

//        $tree = Compute::format($this->rows);

        return $this;
    }

    public function render(){
        ob_start();
        imagepng($this->image);
        $content = ob_get_clean();
        imagedestroy($this->image);
        header("Content-Length:".strlen($content));
        header("Content-Type:image/png");
        echo $content;
    }
}