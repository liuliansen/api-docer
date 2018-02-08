<?php
//+-------------------------------------------------------------
//| 注册类加载函数
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-07
//+-------------------------------------------------------------

require __DIR__.DIRECTORY_SEPARATOR."lib/common.php";

spl_autoload_register(function($clsName){
    $file = __DIR__.DIRECTORY_SEPARATOR.str_replace('\\',DIRECTORY_SEPARATOR,$clsName).'.php';
    if(is_file($file)) require $file;
});