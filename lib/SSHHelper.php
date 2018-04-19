<?php
//+-------------------------------------------------------------
//| 
//+-------------------------------------------------------------
//| Author Liu LianSen <liansen@d3zz.com> 
//+-------------------------------------------------------------
//| Date 2018-04-19
//+-------------------------------------------------------------
namespace lib;

use conf\Base;

class SSHHelper
{
    protected $host = '';

    protected $port = 22;

    protected $user = '';

    protected $password = '';

    protected $conn = null;

    /**
     * SSHHelper constructor.
     * @param $host
     * @param $port
     * @param $user
     * @param $password
     */
    public function __construct($host,$port,$user,$password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param Base $conf
     * @return SSHHelper
     */
    static public function getInstance(Base $conf)
    {
        $ssh = $conf->getSshInfo();
        return new SSHHelper($ssh['host'],$ssh['port'],$ssh['user'],$ssh['password']);
    }

    /**
     * @return resource
     * @throws \Exception
     */
    protected function getConnection()
    {
        if(is_null($this->conn)){
            $this->conn = ssh2_connect($this->host,$this->port);
            if(!$this->conn){
                throw new \Exception('ssh连接失败');
            }
            ssh2_auth_password($this->conn,$this->user,$this->password);
            if(!$this->conn){
                throw new \Exception('ssh登录失败');
            }
        }
        return $this->conn;
    }


    /**
     * 依次获取所有文件的最后修改时间戳
     * @param $files
     * @return array
     */
    public function getFilesLastModifyTimeStamp($files)
    {
        $ret = [];
        foreach ($files as $file){
            try {
                switch ($this->getPathType($file)){
                    case 'file':
                        $ret[$file] = $this->getLastModifyTimeStamp($file);
                        break;
                    case 'dir' :
                        $_ret = $this->getFilesLastModifyTimeStamp(
                            $this->getRegularFiles($file));
                        foreach ($_ret as $item => $v) $ret[$item] = $v;
                        break;
                    default: throw new \Exception('模块路配置错误');
                }
            }catch(\Throwable $e){}
        }
        return $ret;
    }


    /**
     * 判断是否是一个普通文件
     * @param $fileName
     * @return bool
     * @throws \Exception
     */
    public function isFile($fileName)
    {
        $stream = ssh2_exec($this->getConnection(), "stat -c %F {$fileName}");
        if (!$stream) {
            throw new \Exception("{$fileName}文件读取失败");
        }
        $errStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
        stream_set_blocking($stream, true);
        stream_set_blocking($errStream, true);
        if (($err = stream_get_contents($errStream))) {
            throw new \Exception("{$fileName}文件读取失败:{$err}");
        }
        $ret = stream_get_contents($stream);
        fclose($stream);
        fclose($errStream);
        return strpos($ret,'regular file') !== false;
    }

    /**
     * 判断是否是一个目录
     * @param $path
     * @return bool
     * @throws \Exception
     */
    public function isDir($path)
    {
        $stream = ssh2_exec($this->getConnection(), "stat -c %F {$path}");
        if (!$stream) {
            throw new \Exception("{$path}路径读取失败");
        }
        $errStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
        stream_set_blocking($stream, true);
        stream_set_blocking($errStream, true);
        if (($err = stream_get_contents($errStream))) {
            throw new \Exception("{$path}路径读取失败:{$err}");
        }
        $ret = stream_get_contents($stream);
        fclose($stream);
        fclose($errStream);
        return strtolower(trim($ret)) == 'directory';
    }


    /**
     * 获取路径文件类型
     * @param $path
     * @return bool|string  dir:目录，file:普通文件
     * @throws \Exception
     */
    public function getPathType($path)
    {
        $stream = ssh2_exec($this->getConnection(), "stat -c %F {$path}");
        if (!$stream) {
            throw new \Exception("{$path}路径读取失败");
        }
        $errStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
        stream_set_blocking($stream, true);
        stream_set_blocking($errStream, true);
        if (($err = stream_get_contents($errStream))) {
            throw new \Exception("{$path}路径读取失败:{$err}");
        }
        $ret = stream_get_contents($stream);
        fclose($stream);
        fclose($errStream);
        if(strtolower(trim($ret)) == 'directory'){
            return 'dir';
        }elseif(strpos($ret,'regular file') !== false){
            return 'file';
        }
        return false;
    }

    /**
     * 获取文件最后修改时间戳
     * @param $fileName
     * @return int
     * @throws \Exception
     */
    public function getLastModifyTimeStamp($fileName)
    {
        $stream = ssh2_exec($this->getConnection(), "stat -c %Y {$fileName}");
        if (!$stream) {
            throw new \Exception("{$fileName}修改时间获取失败");
        }
        $errStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
        stream_set_blocking($stream, true);
        stream_set_blocking($errStream, true);
        if (($err = stream_get_contents($errStream))) {
            throw new \Exception("{$fileName}修改时间获取失败:{$err}");
        }
        $timeStamp = intval(stream_get_contents($stream));
        fclose($stream);
        fclose($errStream);
        return $timeStamp;
    }

    /**
     * 获取指定路径下所有普通文件(非递归)
     * @param $path
     * @return array
     * @throws \Exception
     */
    public function getRegularFiles($path )
    {
        $stream = ssh2_exec($this->getConnection(), "ls {$path}");
        if (!$stream) {
            throw new \Exception("{$path}目录读取失败");
        }
        $errStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
        stream_set_blocking($stream, true);
        stream_set_blocking($errStream, true);
        if (($err = stream_get_contents($errStream))) {
            throw new \Exception("{$path}目录读取失败:{$err}");
        }
        $ret = stream_get_contents($stream);
        fclose($stream);
        fclose($errStream);
        $files = [];
        $lines = explode("\n",$ret);
        $path = trimLastDS($path);
        foreach ($lines as $line){
            $file = $path.'/'.$line;
            try{
                if($this->isFile($file)){
                    $files[] = $file;
                }
            }catch (\Throwable $e){/*只是为了跳过异常文件名*/}
        }
        return $files;
    }

    /**
     * 获取文件内容
     * @param $file
     * @return bool|string
     * @throws \Exception
     */
    public function getFileContent($file)
    {
        $stream = ssh2_exec($this->getConnection(), "cat {$file}");
        if (!$stream) {
            throw new \Exception("{$file}文件读取失败");
        }
        $errStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
        stream_set_blocking($stream, true);
        stream_set_blocking($errStream, true);
        if (($err = stream_get_contents($errStream))) {
            throw new \Exception("{$file}文件读取失败:{$err}");
        }
        $ret = stream_get_contents($stream);
        fclose($stream);
        fclose($errStream);
        return $ret;
    }

}