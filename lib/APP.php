<?php
//+-------------------------------------------------------------
//| PHP api接口文档生成器
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-08
//+-------------------------------------------------------------
namespace lib;

use conf\Base;
use ReflectionClass;

class APP
{
    static private $urlType = 0; //请求参数类型，0:PATH_INFO,1=请求参数(r)

    /**
     * 默认doc项目
     * @var string
     */
    static private $default = 'Def';

    static private function getPath()
    {
        $pathInfo = '';
        if($_SERVER['PATH_INFO']){
            $pathInfo = $_SERVER['PATH_INFO'];
        }elseif(isset($_GET['r'])){
            $pathInfo = trim($_GET['r']) ?: '';
        }
       return getPath($pathInfo, static::$default, 'default');
    }

    /**
     * 初始创建需要的目录
     */
    static private function createDir()
    {
        if(!is_dir(CACHE_PATH)){
            @mkdir(CACHE_PATH,0777,true);
        }
    }

    /**
     * 获取app的配置对象
     * @param $app
     * @return Base
     */
    static public function getAppConf($app)
    {
        $req = new ReflectionClass('conf\\'.$app);
        return $req->newInstance();
    }

    static public function init()
    {
        static::$urlType = isset($_SERVER['PATH_INFO']) ? 0:1;
        static::createDir();
        list($app,$mod,$api) =  static::getPath();
        static::run($app,$mod,$api);
    }

    static public function run($app,$mod,$api)
    {
        ob_clean();
        try{
            $conf = APP::getAppConf($app);
        }catch (\ReflectionException $e){
            self::response(404);
        }

        if($api){
            $servInfo = $conf->getServerInfo();
            if($api == '__main'){
                $list = CacheReadWriter::getListCache($app,$mod);
                $moduleQty = count($list);
                $apiQty = 0;
                foreach ($list as $item){
                    $apiQty+= count($item);
                }
                $globalAppParams = $conf->getGlobalAppParams();
                $globalApiParams = $conf->getGlobalApiParams();
                $globalDesc      = $conf->getGlobalDesc();
                $responseDesc    = $conf->getResponseDesc();
                require VIEW_PATH . 'main.php';
            }elseif($api == '__search'){
                $keyWord = isset($_GET['key-word'])? trim($_GET['key-word']) :'';
                $apiList = CacheReadWriter::searchApi($app,$mod,$keyWord);
                $result = [];
                foreach ($apiList as $api){
                    if(isset($result[$api['module']])){
                        $result[$api['module']][] = $api;
                    }else{
                        $result[$api['module']] = [$api];
                    }
                }
                require VIEW_PATH . 'search.php';
            }elseif($api == '__call'){ //api调用测试
                echo  ApiCall::call($conf,$app,$mod,$_GET['api'],$_POST);
                exit;
            }else{
                $apiInfo = CacheReadWriter::getApiCache($app,$mod,$api);
                $apiInfo['return'] = $conf->getResponseFormat($apiInfo['return']);
                $globalApiParams = $conf->getGlobalApiParams();

                if(is_null($apiInfo['param'])) $apiInfo['param']= [];
                foreach ($globalApiParams as $param){
                    $found = false;
                    foreach ($apiInfo['param'] as $apiParam){
                        if($param['name'] == $apiParam['name']){
                            $found = true;
                            break;
                        }
                    }
                    if(!$found) array_unshift($apiInfo['param'],$param);
                }
                if(!$apiInfo){
                    self::response(404);
                    exit;
                }
                require VIEW_PATH . 'api.php';
            }
        }else{
            try {
                $conf = self::getAppConf($app);
                switch ($conf->getReadType()){
                    case 'local':
                        $files = FileReader::getModuleFiles($conf, $mod);
                        break;
                    case 'ssh':
                        $files = RemoteReader::getModuleFiles($conf, $mod);
                        break;
                    default: $files = null;
                }

                if(!$files){
                    self::response(404);
                }
            }catch (\ReflectionException $ex){
                self::response(404);
            }catch (\Throwable $e){
                self::response(404,$e->getMessage().PHP_EOL.$e->getTraceAsString());
            }
            CacheReadWriter::createRunCache($app,$mod,$files,$conf);
            $modName = $conf->getModName($mod);
            $list = CacheReadWriter::getListCache($app,$mod);
            $appModuleName = $conf->getModName($mod);
            require VIEW_PATH . 'index.php';
        }
        ob_end_flush();
    }

    static private function response($httpcode,$content = '')
    {
        ob_clean();
        if($httpcode == 404) {
            header("HTTP/1.1 404 Not Found");
            echo str_replace('{message}',$content,file_get_contents(VIEW_PATH .'404.html'));
            exit;
        }
        ob_end_flush();
    }

    static public function getSSHReadBinName()
    {
        return strtolower(PHP_OS) == 'linux' ? 'ssh-read':'ssh-read-win';
    }

}