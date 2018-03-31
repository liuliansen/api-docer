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

    protected $globalAppParams = [
        [
            'name' => 'data',
            'type' => '字符串',
            'require' => '是',
            'default' => '-',
            'desc'    => '接口参数加密后执行base64'
        ],
        [
            'name' => 'iv',
            'type' => '字符串',
            'require' => '是',
            'default' => '-',
            'desc'    => 'data参数加密时所使用的16位iv值,如果未设置data参数则此参数也不需要'
        ],
    ];

    protected $globalApiParams = [
        [
            'name' => 'channelNo',
            'type' => '字符串',
            'require' => '是',
            'default' => '-',
            'desc'    => 'app渠道号'
        ],
        [
            'name' => 'app_version',
            'type' => '字符串',
            'require' => '是',
            'default' => '-',
            'desc'    => 'app版本号'
        ],
        [
            'name' => 'token',
            'type' => '字符串',
            'require' => '是',
            'default' => '-',
            'desc'    => '用户token'
        ],
    ];

    protected $globalDesc =
<<<EOT
“<span style="color:red;">系统级</span>全局请求参数” 可以看做接口统一的请求格式， 在具体接口文档无特别说明时每个接口都必须提供。<br/>
如在接口：“http://xykapi.jrweid.com/api/v1/user-cards?data=xxxxxxx&iv=1234567812345678” 中，data和iv都是必须向系统提供的参数。<br/>
“<span style="color:red;">接口级</span>全局请求参数” 是被包含在系统级参数“data”中的。<br/>
由于在绝大多数接口中都会依赖到这些参数，所以<span style="color:red;">每当提供系统级参数data时，data中都必须包含接口级参数</span>
EOT;

}