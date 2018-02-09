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

    protected $serverInfo = [
        'product_server' => 'http://xykapi.jrweid.com',
        'test_server' => 'http://113.102.103.11:8080',

    ];

    protected $root = '/var/www/html/tp5/application/';

    protected $modules = [
        'default' => '/\/var\/www\/html\/tp5\/application\/.*\/controller\/.*\.php/',
    ];

    protected $moduleNames = [
        'default' => '要点信用卡'
    ];
}