<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-07
//+-------------------------------------------------------------
namespace conf;

abstract class Base
{
    protected $serverInfo = [
        'product_server' => '', //正式服务器地址
        'test_server'    => '', //测试服务器地址
        'note'           => '', //说明
    ];
    protected $root = '';

    protected $modules = [];

    protected $moduleNames = [];

    protected $globalAppParams = [ ];
    protected $globalApiParams = [ ];
    protected $globalDesc      = '';
    protected $responseDesc    = '';
    protected $responseFormat  = '';

    public function getRoot()
    {
        return $this->root;
    }

    public function getGlobalDesc()
    {
        return $this->globalDesc;
    }

    public function getResponseDesc()
    {
        return $this->responseDesc;
    }

    public function getResponseFormat($data = '')
    {
        return $this->responseFormat;
    }

    public function get($mod)
    {
        return isset($this->modules[$mod]) ? $this->modules[$mod] :null;
    }

    public function getModName($mod)
    {
        return isset($this->moduleNames[$mod]) ? $this->moduleNames[$mod] :null;
    }

    public function getServerInfo($key = '')
    {
        if($key)
            return isset($this->serverInfo[$key]) ? $this->serverInfo[$key]:null;
        return $this->serverInfo;
    }

    public function getGlobalAppParams()
    {
        return $this->globalAppParams;
    }
    public function getGlobalApiParams()
    {
        return $this->globalApiParams;
    }
}