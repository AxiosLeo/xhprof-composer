<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 14:43
 */

namespace xhprof\lib;


class Compute
{
    public static $possible_metrics = [
        "wt"  => ["Wall", "microsecs", "wall time"],
        "ut"  => ["User", "microsecs", "user cpu time"],
        "st"  => ["Sys", "microsecs", "system cpu time"],
        "cpu" => ["Cpu", "microsecs", "cpu time"],
        "mu"  => ["MUse", "bytes", "memory usage"],
        "pmu" => ["PMUse", "bytes", "peak memory usage"],
        "samples" => ["Samples", "samples", "cpu time"]
    ];

    public static function getPossibleMetrics(){
        return self::$possible_metrics;
    }

    public static function format($run_data){
        $list = []; $n = 0;
        foreach ($run_data as $k=>$v){
            if(strpos($k,"==>") !== false){
                list($parent_id,$id) = explode('==>',$k);
                $list[$n]['id'] = $id;
                $list[$n]['parent_id'] = $parent_id;
                $list[$n]['data'] = $v;
            }else{
                $list[$n]['id'] = $k;
                $list[$n]['parent_id'] = 0;
                $list[$n]['data'] = $v;
            }
            $n++;
        }

        return $list;
    }

    public static function infiniteTree($data, $parent_index='parent_id', $data_index='id', $child_name='child'){
        $items = [];
        foreach ($data as $d){
            $items[$d[$data_index]] = $d;
            if(!isset($d[$parent_index]) || !isset($d[$data_index]) || isset($d[$child_name])){
                return false;
            }
        }
        $tree = [];$n=0;
        foreach($items as $item){
            if(isset($items[$item[$parent_index]])){
                $items[$item[$parent_index]][$child_name][] = &$items[$item[$data_index]];
            }else{
                $tree[$n++] = &$items[$item[$data_index]];
            }
        }
        return $tree;
    }
}