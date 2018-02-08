<?php

/**
 * 获取请求路径信息
 * @param string $pathInfo
 * @param string $defApp     默认应用
 * @param string $defModule  默认模块
 * @return array
 */
function getPath($pathInfo,$defApp, $defModule)
{
    $siteName = $defApp;
    $modName  = $defModule;
    $api      = '';
    if($pathInfo){
        $pathInfo = trimFirstDirSEP($pathInfo);
        if(strpos($pathInfo,'/') === false){
            $siteName = ucfirst(trim($pathInfo));
        }else{
            $info = explode('/',$pathInfo);
            $cnt = count($info);
            if($cnt >= 2){
                $siteName = ucfirst(trim($info[0]));
                $modName = trim($info[1]);
            }
            if($cnt >= 3) $api = trim($info[2]);
        }
    }
    return [$siteName, $modName, $api];
}

/**
 * @param $pathInfo
 * @return mixed
 */
function trimFirstDirSEP($pathInfo){
    if($pathInfo && strpos($pathInfo,'/') === 0){
        $pathInfo = trimFirstDirSEP(substr($pathInfo,1));
    }
    return $pathInfo;
}

/**
 * 获取模块对应的接口文件列表
 * @param string $root    项目根目录
 * @param mixed $modConf  项目模块配置
 * @return array|null
 */
function getModuleFiles($root,$modConf)
{
    $files = [];
    if(is_string($modConf)){
        //模块文件列表是正则表达式
        if(preg_match("/^\/.*\/i?$/",$modConf)){
            $_files = recursiveGetFiles($root);
            foreach ($_files as $file){
                if(preg_match($modConf,$file))
                    $files[] = $file;
            }
        }
        //是一个目录
        elseif(is_dir($modConf)){
            foreach (scandir($modConf) as $file) {
                $file = $modConf.DIRECTORY_SEPARATOR.$file;
                if(is_file($file)){
                    $files[] = $file;
                }
            }
        }
        //是具体的一个文件
        elseif(is_file($modConf)){
            $files[] = $modConf;
        }
        else return null;
    }
    //配置是一个数组，则将是文件的项加入
    elseif(is_array($modConf)){
        foreach ($modConf as $file) {
            if(is_file($file)){
                $files[] = $file;
            }
        }
    }
    //不支持的配置类型
    else return null;
    $ret = [];
    foreach ($files as $file){
        $ret[$file] = filemtime($file);
    }
    return $ret;
}

/**
 * 递归获取指定目录下的所有文件
 * @param $dir
 * @return array|null
 */
function recursiveGetFiles($dir)
{
    if(substr($dir,strlen($dir)-1) === DIRECTORY_SEPARATOR){
        $dir = substr($dir,0,-1);
    }
    if(!is_dir($dir)) return null;
    $files = [];
    foreach (scandir($dir) as $item){
        if($item === '.' || $item === '..') continue;
        $item = $dir.DIRECTORY_SEPARATOR.$item;
        if(is_file($item)){
            $files[] = $item;
        }
        if(is_dir($item)){
            $files = array_merge($files, recursiveGetFiles($item));
        }
    }
    return $files;
}

/**
 * 将可迭代类型转为数组
 * @param $data
 * @return array|bool
 */
function iterable2Array($data)
{
    if(!is_object($data) && !is_array($data)){
        return false;
    }
    $arr = [];
    foreach ($data as $k => $v){
        $arr[$k] = (is_object($v) || is_array($v)) ? iterable2Array($v) : $v;
    }
    return $arr;
}


