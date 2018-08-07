<?php
/**
 * @author: axios
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 10:51
 */

namespace xhprof;

use xhprof\lib\Compute;
use xhprof\lib\Option;
use xhprof\lib\Report;
use xhprof\lib\Tool;

class XHProf
{
    protected static $runs = [];

    public static function start($flags = XHPROF_FLAGS_MEMORY | XHPROF_FLAGS_CPU | XHPROF_FLAGS_NO_BUILTINS)
    {
        $ignore = self::options()->get('xhprof.ignored_functions', []);
        $ignore = array_merge($ignore, ['xhprof\XHProf::end']);
        self::options()->set('xhprof.ignored_function', $ignore);

        xhprof_enable($flags, self::options()->get('xhprof', []));
    }

    public static function end($name = 'xhprof')
    {
        $xhprof_data = xhprof_disable();
        $run_id      = XHProfRuns::instance($name)->saveData($xhprof_data);

        self::$runs[$name] = $run_id;
        return self::report($run_id);
    }

    public static function getRunId($name = 'xhprof')
    {
        return isset(self::$runs[$name]) ? self::$runs[$name] : null;
    }

    public static function options(array $options = [])
    {
        return Option::instance($options);
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