<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-07
//+-------------------------------------------------------------
require __DIR__.DIRECTORY_SEPARATOR.'autoload.php';
use lib\APP;

define('ROOT_PATH'      , __DIR__ . DIRECTORY_SEPARATOR);
define('RUN_TIME_PATH'  , ROOT_PATH.'runtime'.DIRECTORY_SEPARATOR);
define('CACHE_PATH'     , RUN_TIME_PATH .'cache'.DIRECTORY_SEPARATOR);
define('VIEW_PATH'      , ROOT_PATH .'view'.DIRECTORY_SEPARATOR);

APP::init();




