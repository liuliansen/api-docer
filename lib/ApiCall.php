<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-04-23
//+-------------------------------------------------------------

namespace lib;

use conf\Base;
use httprequest\HttpRequest;
use httprequest\Url;

class ApiCall
{
    static public function call(Base $conf, $app,$mod,$apiMd5,$post)
    {
        try {
            $apiInfo = CacheReadWriter::getApiCache($app, $mod, $apiMd5);
            $portParams = [];
            foreach ($post['params'] as $param){
                $portParams[$param['name']] = $param['value'];
            }
            $params = $conf->getApiRequestParams($portParams);
            $url = new Url($post['url'], $apiInfo['method'], $params);
            $req = new HttpRequest($url);
            curl_setopt($req->getCh(), CURLOPT_HTTPHEADER, $post['headers']);
            $req->request();
            return $conf->getApiResponse($req->getResponseBody());
        }catch (\Throwable $e){
            return $e->getMessage();
        }
    }





    static  protected function getApiRequestParams(Base $conf , array &$params){
        $confParams = $conf->getGlobalApiParams();
        foreach ($confParams as $globalParam){
            $found = false;
            foreach ($params as $apiConf){
                if($apiConf['name'] == $globalParam['name']) {
                    $found = true;
                }
            }
            if(!$found){
                $params[] = $globalParam;
            }
        }
        return $params;
    }



}