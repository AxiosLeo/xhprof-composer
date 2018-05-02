<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 10:51
 */

namespace xhprof;

class XHProfDebug
{
    public static function start($flags = XHPROF_FLAGS_MEMORY | XHPROF_FLAGS_CPU | XHPROF_FLAGS_NO_BUILTINS ,array $options = []){
        $ignore = [
            'xhprof\XHProfDebug::end'
        ];
        $options['ignored_functions'] = isset($options['ignored_functions']) ? array_merge($options['ignored_functions'],$ignore) : $ignore;

        xhprof_enable($flags,$options);
    }

    public static function end($name = 'xhprof',array $options = []){
        $xhprof_data = xhprof_disable();
        $instance = XHProfRuns::instance($name,$options);
        $instance->saveData($xhprof_data);
        return $instance;
    }
}