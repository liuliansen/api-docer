#程序使用说明

本程序实现原理是通过扫描项目源码文件，项目源码中的注释文档生成在线接口文档。

支持多个项目多个模块，通过增加在conf目录下增加conf\Base的子类增加需要管理的项目。
通过子类中$modules设置项目模块。
接口访问地址为 your_api_doc_domain.com/配置类名/模块编码
如
~~~ 
    /* 定义了多个模块
     * 假设配置文件名为 Test,
     * 那么
     * default 模块的访问路径为 your_api_doc_domain.com/test/default 或 your_api_doc_domain.com/test
     * backend 模块的访问路径为 your_api_doc_domain.com/test/backend
     * default模块为项目默认模块
     */ 
    protected $modules = [
         //指定目录
        'default' => '/var/www/html/tp5/application/appclient/controller',
        //通过正则指定多个目录
        'backend' => '/^\/var\/www\/html\/tp5\/application\/(article|bank|common|fund|index|msg|report|shebao|sys|user)\/controller\/.*\.php$/', 
    ];
    
    //设置某块名称
    protected $moduleNames = [
        'default' => '要点信用卡',
        'backend' => '管理后台',
    ];
~~~

文档生成说明
![alt 生成说明](assets/img/readmeimg/01.png)

接口源码注释说明
文档生成说明
![alt 生成说明](assets/img/readmeimg/02.png)

##注释语法示例

|注释标签    | 说明                             |注释对象|<br/>
| @module    | 设置接口归属模块(在线文档的目录) | class, function|<br/>
| @url       | 设置接口地址                     | function|<br/>
| @method    | 设置请求方式（GET,POST...）      | function|<br/>
| @author    | 设置接口作者                     | function|<br/>
| @param     | 设置接口参数                     | function|<br/>
| @docreturn | 设置接口返回说明                 | function|<br/>
~~~
<?php

/**
 * Class Sys
 * @module 系统
 * @package app\appclient\controller
 */
class Sys extends AppController
{
/**
     * 获取客服电话及工作时间
     * @title 客服信息
     * @url /api/v1/customer-service-info
     * @method get
     * @author LianSen<liansen@d3zz.com>
     * @param name:test type:string require:1 default:""  desc:测试参数
     * @return \think\response\Json
     * @docreturn {
     *  tel : string, //客服电话
     *  day:{
     *      start : string , //起始日，如"周一"
     *      end : string , //结束日，如"周五"
     *  },
     *  time:{
     *      start : string , //起始时间，如："9:00"
     *      end : string , //结束时间，如"18:00"
     *  }
     * }
     */
    public function serviceInfo()
    {

    }
}


~~~
