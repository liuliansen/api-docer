<?php
//+-------------------------------------------------------------
//| PHP api接口文档生成器
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-08
//+-------------------------------------------------------------
namespace lib;

use ReflectionClass;

class APP
{
    static private $urlType = 0; //请求参数类型，0:PATH_INFO,1=请求参数(r)

    /**
     * 默认doc项目
     * @var string
     */
    static private $default = 'Xyk';

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
     * @return object
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
        if($api){ //查看具体接口文档
        }else{   //获取指定模块的接口列表
            try {
                $files = FileReader::getModuleFiles($app, $mod);
            }catch (\ReflectionException $ex){
                self::response(404);
                exit;
            }
            CacheReadWriter::createRunCache($app,$mod,$files);
        }
        static::run($app,$mod,$api);
    }

    static public function run($app,$mod,$api)
    {
        $modName = APP::getAppConf($app)->getModName($mod);
        ob_clean();
        if($api){

        }else{
            $list = CacheReadWriter::getListCache($app,$mod);
            require VIEW_PATH . 'index.php';
        }
        ob_end_flush();
    }

    static private function response($httpcode,$content = '')
    {
        ob_clean();
        if($httpcode == 404) {
            header("HTTP/1.1 404 Not Found");
            echo file_get_contents(VIEW_PATH .'404.html');
        }
        ob_end_flush();
    }

}