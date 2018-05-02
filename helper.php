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