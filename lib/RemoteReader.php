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
//        $sshHelper = SSHHelper::getInstance($conf);
        $modConf = $conf->get($mod);
        $files = [];
        switch (gettype($modConf)){
            case 'array':
                $modConf = str_replace("\"","\\\"",json_encode($modConf,JSON_UNESCAPED_UNICODE));
//                    $files = $sshHelper->getFilesLastModifyTimeStamp($modConf);
                    break;
            case  'string':
//                    if(preg_match("/^\/.*[\*|\?].*\/i?$/",$modConf)){ //正则
//                        throw new \Exception('远程模式下禁用正则指定源码路径');
//                    }elseif($sshHelper->isFile($modConf)){
//                        $files[$modConf] = $sshHelper->getLastModifyTimeStamp($modConf);
//
//                    }elseif($sshHelper->isDir($modConf)){
//                        $files = $sshHelper->getFilesLastModifyTimeStamp(
//                                                $sshHelper->getRegularFiles($modConf));
//
//                    }
                $modConf = str_replace("\"","\\\"",json_encode([$modConf],JSON_UNESCAPED_UNICODE));
                    break;
            default:throw new \Exception('模块源码路径配置错误');
        }
        $ssh = $conf->getSshInfo();
        $bin = APP::getSSHReadBinName();

        @exec(ROOT_PATH ."{$bin} -h {$ssh['host']} -P {$ssh['port']} -u {$ssh['user']} -p {$ssh['password']} -m info -c {$modConf}",$out,$return);
        foreach ($out as $row){
            $json = json_decode($row);
            if($json){
               $arr = iterable2Array($json);
               $file = array_keys($arr)[0];
               $files[$file] = $arr[$file];
            }
        }
        return $files ?: null;
    }
}
