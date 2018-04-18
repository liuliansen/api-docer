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
/**
 * @module 用户管理
 */
class Test
{
    /**
     * status状态码说明:<br/>
     * <table border=1>
     * <tr><th>status</th><th>含义</th></tr>
     * <tr><td>200</td><td>注册成功</td></tr>
     * <tr><td>400</td><td>错误请求，具体原因见message字段</td></tr>
     * <tr><td>406</td><td>电话号码已注册过</td></tr>
     * <tr><td>500</td><td>服务器错误，联系后端技术</td></tr>
     * </table>
     * @title 用户注册
     * @url /api/v1/users
     * @method post
     * @author LianSen <liansen@d3zz.com>
     * @param name:phone type:string require:1 desc:用户手机号码
     * @param name:password type:string require:1 desc:md5加密的用户密码
     * @param name:captcha type:string require:1 desc:短信验证码（6位）
     * @param name:loginToken     type:string require:1 desc:判断是否最后登录设备token
     * @param name:devicePlatform type:string require:1 desc:设备平台（1=ios,2=android）
     * @param name:deviceToken    type:string require:0 default:空字符串 desc:设备号(真正的设备号，消息推送使用该字段)
     * @param name:inviteCode     type:string require:0 desc:邀请码
     * @param name:channelNo     type:string require:0 desc:渠道号（ios固定传“ios”）
     * @return \think\response\Json
     * @docreturn {
     *      token: string //用户的token
     * }
     */
     public function register(){
      //yor code
     }

}


~~~
