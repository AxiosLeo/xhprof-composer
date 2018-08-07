<?php
/**
 * @author: axios
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 10:51
 */

namespace xhprof;

use api\tool\lib\ArrayTool;
use xhprof\lib\Compute;
use xhprof\lib\Report;
use xhprof\lib\Tool;

class XHProf
{
    public static function start($flags = XHPROF_FLAGS_MEMORY | XHPROF_FLAGS_CPU | XHPROF_FLAGS_NO_BUILTINS, array $options = [])
    {
        $ignore = [
            'xhprof\XHProfDebug::end'
        ];

        $options['ignored_functions'] = isset($options['ignored_functions']) ? array_merge($options['ignored_functions'], $ignore) : $ignore;

        xhprof_enable($flags, $options);
    }

    public static function end($name = 'xhprof', array $options = [])
    {
        $xhprof_data = xhprof_disable();
        $run_id      = XHProfRuns::instance($name, $options)->saveData($xhprof_data);
        return self::report($run_id);
    }

    private static $options;

    public static function options(array $options = [])
    {
        if (is_null(self::$options)) {
            self::$options = ArrayTool::instance([]);
        }
        self::$options->set($options);
        return self::$options;
    }

    public static function report($run_id)
    {
        $rows = XHProfRuns::query()->find($run_id);
        $list = Compute::format($rows);
        $tree = Compute::infiniteTree($list);
        $root = $tree[0];
        Tool::compute_info($tree, $root['data']['wt'], $root['data']['mu'], $root['data']['cpu']);

        $report = new Report([
            'total_wall_time' => $root['data']['wt'],
            'total_memory'    => $root['data']['mu'],
            'total_cpu_time'  => $root['data']['cpu'],
            'list'            => $list,
            'tree'            => $tree
        ]);
        return $report;
    }
}