<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-07
//+-------------------------------------------------------------
namespace lib;

class FileReader
{

    /**
     * @param $app
     * @param $modName
     * @return array|null
     * @throws \ReflectionException
     */
    static public function getModuleFiles($app,$modName)
    {
        $conf = APP::getAppConf($app);
        $modConf = $conf->get($modName);
        if(is_null($modConf)){
            return  null;
        }
        return getModuleFiles($conf->getRoot(),$modConf);
    }
}

