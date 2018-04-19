<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-07
//+-------------------------------------------------------------

use lib\APP;
require __DIR__.DIRECTORY_SEPARATOR.'autoload.php';

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH'      , __DIR__ . DS);
define('RUN_TIME_PATH'  , ROOT_PATH.'runtime'.DS);
define('CACHE_PATH'     , RUN_TIME_PATH .'cache'.DS);
define('VIEW_PATH'      , ROOT_PATH .'view'.DS);
APP::init();




