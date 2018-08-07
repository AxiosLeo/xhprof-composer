<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018/8/7 15:27
 */

namespace xhprof\lib;


class Tool
{
    public static function compute_info(&$tree, $total_time, $total_memory, $total_cpu)
    {
        foreach ($tree as &$t) {
            $time   = $t['data']['wt'];
            $memory = $t['data']['mu'];
            $cpu    = $t['data']['cpu'];

            if (isset($t['child']) && !empty($t['child'])) {
                foreach ($t['child'] as $c) {
                    $time   -= $c['data']['wt'];
                    $memory -= $c['data']['mu'];
                    $cpu    -= $c['data']['cpu'];
                }
                self::compute_info($t['child'], $total_time, $total_memory, $total_cpu);
            }

            $t['data']['EWall']    = $time;
            $t['data']['EWall%']   = self::percent_format($time, $total_time);
            $t['data']['EMemUse']  = $memory;
            $t['data']['EMemUse%'] = self::percent_format($memory, $total_memory);
            $t['data']['ECPU']     = $cpu;
            $t['data']['ECPU%']    = self::percent_format($cpu, $total_cpu);

        }
    }

    public static function percent_format($num, $total)
    {
        $percent = ((float)$num * 100) / $total;
        $percent = number_format($percent, 3, '.', ',');
        return $percent . "%";
    }

    public static function time_format($time)
    {
        if ($time > 1000000) {
            $time = number_format((float)$time / 1000000, 3, '.', ',') . "s";
        } else {
            $time = number_format((float)$time / 1000, 3, '.', ',') . "ms";
        }
        return $time;
    }

    public static function byte_format($bytes)
    {
        if (!is_numeric($bytes) || $bytes <= 0) {
            return false;
        }
        $unit = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        $i    = floor(log($bytes, 1024));
        $i    = $i < 5 ? $i : 5;
        $a    = $bytes / pow(1024, $i);

        return isset($unit[$i]) ? round($a, 2) . ' ' . $unit[$i] : $bytes . 'B';
    }
}