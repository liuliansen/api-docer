<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-04-19
//+-------------------------------------------------------------
namespace lib;

use conf\Base;

class RemoteReader
{
    static public function getModuleFiles(Base $conf,$mod)
    {
        $sshHelper = SSHHelper::getInstance($conf);
        $modConf = $conf->get($mod);
        $files = null;
        $start = microtime(1);
        switch (gettype($modConf)){
            case 'array':
                    $files = $sshHelper->getFilesLastModifyTimeStamp($modConf);
                    break;
            case  'string':
                    if(preg_match("/^\/.*[\*|\?].*\/i?$/",$modConf)){ //正则
                        throw new \Exception('远程模式下禁用正则指定源码路径');
                    }elseif($sshHelper->isFile($modConf)){
                        $files[$modConf] = $sshHelper->getLastModifyTimeStamp($modConf);

                    }elseif($sshHelper->isDir($modConf)){
                        $files = $sshHelper->getFilesLastModifyTimeStamp(
                                                $sshHelper->getRegularFiles($modConf));

                    }
                    break;
            default:throw new \Exception('模块源码文件配置错误');
        }
        echo "获取文件列表:".(microtime(1)- $start).'<br>';
        return $files;
    }
}
