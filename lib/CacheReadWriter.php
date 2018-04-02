<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-08
//+-------------------------------------------------------------
namespace lib;

class CacheReadWriter
{

    /**
     * 获取app的mod缓存目录
     * @param $app
     * @param $mod
     * @return string
     */
    static public function getAppModCachePath($app, $mod)
    {
        $cacheDir = CACHE_PATH.$app.DIRECTORY_SEPARATOR.$mod.DIRECTORY_SEPARATOR;
        if(!is_dir($cacheDir)) @mkdir($cacheDir,0777,true);
        return $cacheDir;
    }

    /**
     * 获取文件信息缓存
     * @param $app
     * @param $mod
     * @return array
     */
    static public function getFileInfoCache($app,$mod)
    {
        $files = [];
        $cacheFile = static::getFileInfoCacheFile($app,$mod);
        if(is_file($cacheFile)){
            $data = file_get_contents($cacheFile);
            if($data){
                $files = iterable2Array(json_decode($data))?: [];
            }
        }
        return $files;
    }

    /**
     * 更新应用模块文件信息缓存
     * @param $app
     * @param $mod
     * @param $files
     * @return bool
     */
    static public function updateFileInfoCache($app,$mod,$files)
    {
        $cache = static::getFileInfoCache($app,$mod);
        $newInfo = array_merge($cache, $files);
        file_put_contents(CacheReadWriter::getFileInfoCacheFile($app,$mod),json_encode($newInfo));
        return true;
    }

    /**
     * 更新api接口缓存索引缓存
     * 建立url+method映射缓存文件的关系
     * @param $app
     * @param $mod
     */
    static private function updateApiIndexCache($app,$mod)
    {
        $cacheDir = static::getAppModCachePath($app,$mod).'files';
        $index = [];
        foreach (scandir($cacheDir) as $item){
            if($item == '.' || $item == '..') continue;
            $cacheFile = $cacheDir.DIRECTORY_SEPARATOR.$item;
            $data = file_get_contents($cacheFile);
            if($data){
                $json = json_decode($data);
                if($json){
                    $apis = iterable2Array($json);
                    foreach ($apis as $api){
                        $index[md5($api['url'].$api['method'])] = $cacheFile;
                    }
                }
            }
        }
        $indexCacheFile = static::getFileInfoCacheFile($app,$mod,'index');
        file_put_contents($indexCacheFile,json_encode($index));
    }


    /**
     * 读取指定接口信息
     * @param $app
     * @param $mod
     * @param $apiMd5
     * @return bool|mixed
     */
    static public function getApiCache($app,$mod,$apiMd5)
    {
        $indexCacheFile = static::getFileInfoCacheFile($app,$mod,'index');
        $data = file_get_contents($indexCacheFile);
        if($data) {
            if(($json = json_decode($data)) && $json){
                $arr = iterable2Array($json);
                foreach ($arr as $md5 => $cacheFile){
                    if($md5 == $apiMd5){
                        $cache = static::readApiFileCache($app,$mod,$cacheFile);
                        foreach ($cache as $item){
                            if($item['md5'] == $apiMd5) return $item;
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * 生成api文件解析缓存
     * @param $app
     * @param $mod
     * @param $files
     * @return bool
     */
    static public function createRunCache($app,$mod,$files)
    {
        $cacheFiles = static::getFileInfoCache($app,$mod);
        $updated = false; //是否有新的更新
        foreach ($files as $file => $mTime){
            if(!isset($cacheFiles[$file]) || $cacheFiles[$file] < $mTime){ //需要生成新的缓存
                $updated = true;
                $info = CommentParser::parse($app,$mod,$file);
                static::writeApiFileCache($app,$mod,$file,$info);
            }
        }
        if($updated) {
            static::updateFileInfoCache($app,$mod,$files);
            static::updateApiIndexCache($app,$mod);
            static::createListCache($app,$mod);
        }
        return true;
    }

    /**
     * 获取对应应用模块的缓存信息文件
     * @param $app
     * @param $mod
     * @param $type
     * @return string
     */
    static public function getFileInfoCacheFile($app, $mod,$type = 'files')
    {
        $cacheDir = static::getAppModCachePath($app, $mod);
        $file = '';
        if($type == 'files'){
            $file = $cacheDir.DIRECTORY_SEPARATOR.'files.cache';
        }elseif($type == 'index'){
            $file = $cacheDir.DIRECTORY_SEPARATOR.'index.cache';
        }
        return $file;
    }

    /**
     * 将文件提取到的接口信息写入到文件缓存
     * @param $app
     * @param $mod
     * @param $file
     * @param $info
     */
    static public function writeApiFileCache($app,$mod,$file,$info)
    {
        $cacheDir = static::getAppModCachePath($app, $mod).'files';
        if(!is_dir($cacheDir)) @mkdir($cacheDir,0777, true);
        $cacheFile = $cacheDir.DIRECTORY_SEPARATOR.md5($file).'.cache';
        file_put_contents($cacheFile, json_encode($info,JSON_UNESCAPED_UNICODE));
    }

    /**
     * 读取指定的api缓存文件数据
     * @param $app
     * @param $mod
     * @param $cacheFile
     * @return array|bool
     */
    static public function readApiFileCache($app,$mod,$cacheFile)
    {
        if(!is_file($cacheFile)) return false;
        $data = file_get_contents($cacheFile);
        if(!$data)  return false;
        $json = json_decode($data);
        if(!$json) return false;
        return iterable2Array($json);
    }


    /**
     * 生成模块api列表缓存
     * @param $app
     * @param $mod
     */
    static public function createListCache($app,$mod)
    {
        $cacheDir = static::getAppModCachePath($app, $mod).'files';
        $modules = [];
        foreach (scandir($cacheDir) as $item){
            if($item == '.' || $item == '..') continue;
            $file = $cacheDir.DIRECTORY_SEPARATOR.$item;
            $data = file_get_contents($file);
            if($data) {
                $json = json_decode($data);
                if($json) {
                    $apis = iterable2Array($json);
                    foreach ($apis as $api){
                        //                        if($api['module']=='测试'){
//                            var_dump($api);
//                            var_dump($modules[$api['module']]);
//                        }
                        if(isset($modules[$api['module']])){
                            $modules[$api['module']][md5($api['url'].$api['method'])] = $api['title'];
                        }else{
                            $modules[$api['module']] = [
                                md5($api['url'].$api['method']) => $api['title']
                            ];
                        }
                    }
                }
            }
        }
        $lisCacheFile = static::getAppModCachePath($app,$mod).'list.cache';
        file_put_contents($lisCacheFile, json_encode($modules,JSON_UNESCAPED_UNICODE));
    }

    /**
     * 获取api列表
     * @param $app
     * @param $mod
     * @return array|bool
     */
    static public function getListCache($app,$mod)
    {
        $lisCacheFile = static::getAppModCachePath($app,$mod).'list.cache';
        $data = file_get_contents($lisCacheFile);
        if($data){
            if(($json = json_decode($data)) && $json){
                return iterable2Array($json);
            }
        }
        return [];
    }

    /**
     * 查询包含关键字的api列表
     * @param $keyWord
     * @return array
     */
    static public function searchApi($app,$mod,$keyWord)
    {
        if(!$keyWord) return [];
        $apiList = CacheReadWriter::getListCache($app,$mod);
        $result = [];
        foreach ($apiList as $moduleList){
            foreach ($moduleList as $md5 => $api){
                if(preg_match("/{$keyWord}/i",$api)){
                    $info = CacheReadWriter::getApiCache($app,$mod,$md5);
                    $result[] = $info;
                }
            }
        }
        return $result;
    }

}

