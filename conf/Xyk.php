<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-07
//+-------------------------------------------------------------
namespace conf;

class Xyk extends Base
{

    protected $root = '/var/www/html/tp5/application/';

    protected $modules = [
        'default' => '/\/var\/www\/html\/tp5\/application\/.*\/controller\/.*\.php/',
    ];

    protected $moduleNames = [
        'default' => '要点信用卡'
    ];
}