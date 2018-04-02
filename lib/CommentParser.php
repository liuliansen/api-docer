<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-08
//+-------------------------------------------------------------
namespace lib;

class CommentParser
{
    static public function parse($app,$mod,$file)
    {
        $content = file_get_contents($file);
        if(preg_match_all("#\/\*{2}(.*)\*\/#sSU",$content,$m) && isset($m[1])){
            $info = [];
            $module = '';
            foreach ($m[1] as $comm){
                if($module === '' && preg_match('#@module\s+(.*)#m',$comm,$m)){
                    $module = trim($m[1]);
                }
                if(!preg_match('#@url#m',$comm) || !preg_match('#@method#m',$comm)) continue;
                $lineEOF = (strpos($comm,"\r\n") === false) ? "\n":"\r\n";
                $lines = explode($lineEOF,$comm);
                $api = [
                    'description' => [],
                    'module'     => '',
                    'title'       => '',
                    'url'         => '',
                    'method'      => '',
                    'author'      => '',
                    'param'       => [],
                    'return'      => [],
                    'lastLabel'   => ''
                ];
                foreach ($lines as $line){
                    static::parseLine($api,$line);
                }
                if(!$api['module']) {
                    $api['module'] = $module ?: APP::getAppConf($app)->getModName($mod);
                }
                $api['md5'] = md5($api['url'].$api['method']);
                $info[] = $api;
            }
            return $info;
        }
        return false;
    }

    static private function parseLine(&$api,$line)
    {
        $line = substr(trim($line),1);
        if(!$line) return;
        if(strpos($line,'@') === false){
            if($api['lastLabel'] == 'docreturn'){
                $api['return'][] = $line;
            }else{
                $api['description'][] = $line;
                $api['lastLabel'] = 'description';
            }
        }else {
            if (preg_match('/@(.+?)\s+(.*)$/', $line, $m)) {
                switch ($m[1]) {
                    case 'title':
                    case 'author':
                    case 'module':
                    case 'url':
                    case 'method':
                        $api[$m[1]] =  $m[2];
                        break;
                    case 'description':
                        $api['description'][] = $m[2];
                        break;
                    case 'docreturn':
                        $api['return'][] = $m[2];
                        break;
                    case 'param':
                        $set =  explode(' ',$m[2]);
                        $info = [];
                        foreach ($set as $s){
                            if(!$s) continue;
                            $index = strpos($s,':');
                            //被空格隔断，却又没有':'号，则追加到上一个选项
                            if($index === false){
                                end($info) && ($info[key($info)] .= ' '.$s);
                            }else{
                                $info[substr($s,0,$index)] = substr($s,$index+1);
                            }
                        }
                        $api['param'][] = $info;
                        break;
                }
                $api['lastLabel'] = $m[1];
            }
        }
    }
}

