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
    protected $root = '';

    protected $modules = [];

    protected $moduleNames = [];

    public function getRoot()
    {
        return $this->root;
    }

    public function get($mod)
    {
        return isset($this->modules[$mod]) ? $this->modules[$mod] :null;
    }

    public function getModName($mod)
    {
        return isset($this->moduleNames[$mod]) ? $this->moduleNames[$mod] :null;
    }
}