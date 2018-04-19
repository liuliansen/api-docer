<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-07
//+-------------------------------------------------------------
namespace lib;

use conf\Base;

class FileReader
{

    /**
     * @param Base $conf
     * @param $modName
     * @return array|null
     * @throws \ReflectionException
     */
    static public function getModuleFiles($conf,$modName)
    {
        $modConf = $conf->get($modName);
        if(is_null($modConf)){
            return  null;
        }
        return getModuleFiles($conf->getRoot(),$modConf);
    }
}

