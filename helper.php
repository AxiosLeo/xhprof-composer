<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/2 10:57
 */

if(!function_exists('dump')){
    /**
     * @param null $var
     * @param bool $echo
     * @param null $label
     * @param int $flags
     * @return null|string|string[]
     */
    function dump($var = null, $echo = true, $label = null, $flags = ENT_SUBSTITUTE){
        $label = (null === $label) ? '' : rtrim($label) . ':';
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
        $is_cli = PHP_SAPI == 'cli' ? true : false;
        if ($is_cli) {
            $output = PHP_EOL . $label . $output . PHP_EOL;
        } else {
            if (!extension_loaded('xdebug')) {
                $output = htmlspecialchars($output, $flags);
            }
            $output = '<pre>' . $label . $output . '</pre>';
        }
        if ($echo) {
            echo($output);
            return '';
        } else {
            return $output;
        }
    }
}

if(!function_exists('xhprof_driver')){
    /**
     * @param $options
     * @return \xhprof\driver\Driver
     */
    function xhprof_driver(array $options){
        if(!isset($options['driver'])){
            $options['driver'] = 'file';
        }
        $driver = strtolower($options['driver']);
        $driverList = [
            'file', 'mongo', 'redis'
        ];
        if (!in_array($driver, $driverList)) {
            $driver = 'file';
        }

        $driver = "xhprof\\driver\\" . ucfirst($driver);

        $driverObj = new $driver($options);
        return $driverObj;
    }
}

if(!function_exists('xhprof_compute_info')){
    function xhprof_compute_info(&$tree, $total_time, $total_memory, $total_cpu){
        foreach ($tree as &$t){
            $time = $t['data']['wt'];
            $memory = $t['data']['mu'];
            $cpu = $t['data']['cpu'];

            if(isset($t['child']) && !empty($t['child'])){
                foreach ($t['child'] as $c) {
                    $time -= $c['data']['wt'];
                    $memory -= $c['data']['mu'];
                    $cpu -= $c['data']['cpu'];
                }
                xhprof_compute_info($t['child'], $total_time, $total_memory, $total_cpu);
            }

            $t['data']['EWall'] = $time;
            $t['data']['EWall%'] = xhprof_percent_format($time,$total_time);
            $t['data']['EMemUse'] = $memory;
            $t['data']['EMemUse%'] = xhprof_percent_format($memory,$total_memory);
            $t['data']['ECPU'] = $cpu;
            $t['data']['ECPU%'] = xhprof_percent_format($cpu,$total_cpu);

        }
    }
}

if(!function_exists('xhprof_percent_format')){
    function xhprof_percent_format($num,$total){
        $percent = ((float) $num * 100) / $total;
        $percent = number_format($percent,3,'.',',');
        return $percent . "%";
    }
}

if(!function_exists('xhprof_time_format')){
    function xhprof_time_format($time){
        if($time > 1000000){
            $time =  number_format((float) $time/1000000,3,'.',',')."s";
        }else{
            $time = number_format((float) $time/1000,3,'.',',')."ms";
        }
        return $time;
    }
}

if(!function_exists('xhprof_byte')){
    function xhprof_byte($bytes){
        if(!is_numeric($bytes) || $bytes <= 0) {
            return false;
        }
        $unit=array('B','KB','MB','GB','TB','PB');
        $i=floor(log($bytes,1024));
        $i = $i< 5 ? $i:5;
        $a =$bytes/pow(1024,$i);

        return  isset($unit[$i]) ? round($a,2) .' '.$unit[$i]:$bytes.'B';
    }
}
