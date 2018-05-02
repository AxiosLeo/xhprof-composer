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

        $max_width = 5;
        $max_height = 3.5;
        $max_fontsize = 35;
        $max_sizing_ratio = 20;
    }
}