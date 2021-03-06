<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-02-07
//+-------------------------------------------------------------
namespace conf;

class Def extends Base
{

    protected $readType = 'local';

    protected $serverInfo = [
        'product_server' => 'http://open.test.com',
        'test_server'    => 'http://test.test.com',

    ];

    protected $root = '/var/www/html/tp5/application';


    protected $modules = [
        'default' =>   '/var/www/html/tp5/application/appclient/controller/',
        'backend' => '/^\/var\/www\/html\/tp5\/application\/(article|bank|common|fund|index|msg|report|shebao|sys|user)\/controller\/.*\.php$/',
    ];

    protected $moduleNames = [
        'default' => '演示项目'
    ];

    protected $globalAppParams = [
        [
            'name' => 'data',
            'type' => 'string',
            'require' => '1',
            'default' => '-',
            'desc'    => '接口参数加密后执行base64'
        ],
        [
            'name' => 'iv',
            'type' => 'string',
            'require' => '1',
            'default' => '-',
            'desc'    => 'data参数加密时所使用的16位iv值,如果未设置data参数则此参数也不需要'
        ],
    ];

    protected $globalApiParams = [
        [
            'name' => 'channelNo',
            'type' => 'string',
            'require' => '1',
            'default' => '-',
            'desc'    => 'app渠道号'
        ],
        [
            'name' => 'app_version',
            'type' => 'string',
            'require' => '1',
            'default' => '-',
            'desc'    => 'app版本号'
        ],
        [
            'name' => 'token',
            'type' => 'string',
            'require' => '1',
            'default' => '-',
            'desc'    => '用户token'
        ],
    ];

    protected $globalDesc =
<<<EOT
“<span style="color:red;">系统级</span>全局请求参数” 可以看做接口统一的请求格式， 在具体接口文档无特别说明时每个接口都必须提供。<br/>
如在接口：“http://open.test.com/api/v1/user-cards?data=xxxxxxx&iv=1234567812345678” 中，data和iv都是必须向系统提供的参数。<br/>
“<span style="color:red;">接口级</span>全局请求参数” 是被包含在系统级参数“data”中的。<br/>
由于在绝大多数接口中都会依赖到这些参数，所以<span style="color:red;">每当提供系统级参数data时，data中都必须包含接口级参数</span>
EOT;

    protected $responseDesc =
<<<EOT
响应返回json字符串

{
  "status": int ,       //执行返回状态码,
  "message":string ,    //执行返回信息,
  "iv":string ,         //返回data的解密iv(如果开启了加密),
  "login_token":string  //最后登录设备loginToken,
  "data":mixed          //数组、JSON对象
}
EOT;

    public function getResponseFormat($data = '')
    {
        $return = '';
        foreach ($data as $row){
            $return .= "\t".$row."\r\n";
        }
        if(!$return) $return = '[]';
        return <<<EOT
{
  "status": int ,       //执行返回状态码,
  "message":string ,    //执行返回信息,
  "iv":string ,         //返回data的解密iv(如果开启了加密),
  "login_token":string  //最后登录设备loginToken,
  "data":{$return}        
}
EOT;


    }
    protected function getIv()
    {
        $iv = '';
        for ($i = 0;$i<16;$i++){
            $iv .= mt_rand(0,9);
        }
        return $iv;
    }

    protected $sslKey = 'asdfsdc3949ba59abbe56e057f20f883';

    public function getApiRequestParams($params =[])
    {
        $data = json_encode($params,JSON_UNESCAPED_UNICODE);
        $iv = $this->getIv();
        return [
            'data' => base64_encode(openssl_encrypt($data,'AES-256-CBC',$this->sslKey,OPENSSL_RAW_DATA ,$iv)),
            'iv'  => $iv
        ];
    }

    public function getApiResponse($response){
        try{
            $json = json_decode($response);
            if(!$json){
                return $response;
            }
            $data = openssl_decrypt(base64_decode($json->data),'AES-256-CBC',$this->sslKey,OPENSSL_RAW_DATA,$json->iv);
            $json->data = json_decode($data);
            return json_encode($json,JSON_UNESCAPED_UNICODE);
        }catch (\Exception $e){
            return $response;
        }
    }
}