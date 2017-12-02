<?php
$timestart=microtime(true);
$mem = memory_get_usage();

/**
 *  Environment setup( development, production, testing)
 *	Error reporting setup based on environment
 *
 */

/**
 *	Error reporting
 */

define('ENVIRONMENT', 'development');//'production' 'test'

if (defined('ENVIRONMENT'))
{
    switch (ENVIRONMENT)
    {
        case 'development':
            //error_reporting(E_ALL | E_STRICT);
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_errors', 1);
            break;
            
        case 'test':
        case 'production':
            //ini_set('display_errors', 1);
            error_reporting(0);
            break;
            
        default:
            exit('The application environment is not set correctly.');
    }
}

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH',__DIR__);
define('SYS_PATH',  BASE_PATH.DS.'system');
define('APP_PATH', BASE_PATH.DS.'app');

require_once BASE_PATH.DS.'bootstrap.php';

define('BASE_URL', \System\Loader::config('configs', array(), true)['base_url']);

$core = new \System\Core();

$core->run();


$timeend=microtime(true);
$time=$timeend-$timestart;


$page_load_time = number_format($time, 3);

echo "<br/>Debut du script: ".date("H:i:s", $timestart);
echo "<br/>Fin du script: ".date("H:i:s", $timeend);
echo "<br/>Script execute en " . $page_load_time . " sec";
$unit=array('b','kb','mb','gb','tb','pb');
echo '<br/>Used memory: '.@round($size/pow(1024,($i=floor(log(memory_get_usage() - $mem,1024)))),2).' '.$unit[$i];
//echo '<br/>Used memory: '.(memory_get_usage() - $mem) / (1024 * 1024);