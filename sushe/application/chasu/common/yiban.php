<?php
/**
 * Created by PhpStorm
 * User: Dujianjun
 * Date: 2019/9/7
 * Time: 下午11:33
 */
namespace app\chasu\common;

use think\facade\Config;

class yiban
{
    private  $appId;
    private  $appSecret;
    private $url;
    private  $key;
    private  $iv;
    private $info;
    private $token;
    private $yb_uid;

    public function __construct()
    {
        $this->appId = Config::get("yiban.appId");
        $this->appSecret = Config::get("yiban.appSecret");
        $this->url = Config::get("yiban.url");
        $this->key=md5($this->appSecret);
        $this->iv=substr(md5($this->appId),0,16);
        if (!isset($_COOKIE['tokenInfo']))
        {
            $this->redirect();
        }
        $this->info=json_decode($this->decrypt($_COOKIE['tokenInfo']));
        if (!$this->info){
            $this->redirect();
        }
        $this->token=$this->info->token;
        $this->yb_uid=$this->info->yb_uid;
    }

    /**
     * 检查token是否有效
     * @return bool|mixed
     */
    function index(){
        return true;
    }
    function check(){
        $request_array=[
            "client_id" => $this->appId,
            "access_token" => $this->token
        ];
        $req_str=http_build_query($request_array);
        $result = json_decode($this->sendRequest("https://openapi.yiban.cn/oauth/token_info",$req_str));
        if ($result->status==200){
            return $result;
        }else{
            $this->redirect();
            return false;
        }
    }

    /**
     * 跳转到应用首页
     */
    function redirect(){
        header("Location:$this->url");
        exit();
    }

    /**
     * 解密
     * @param $cipher 密文 cookie的tokenInfo
     * @return string
     */
    private function decrypt($cipher){
        return openssl_decrypt($cipher,"aes-128-cbc",$this->key,1,$this->iv);
    }

    /**
     * 获取 yb_uid
     * @return mixed
     */
    function getUid(){
        return $this->yb_uid;
    }

    /**
     * 获取 token
     * @return mixed
     */
    function getToken(){
        return $this->token;
    }

    /**
     * 给易班用户发送app通知消息
     * @param $to_yb_user 给谁发
     * @param $content 发的内容
     * @return bool|string
     */
    function ybSendText($to_yb_user,$content){
        $post_array=[
            "access_token" => $this->token,
            "to_yb_uid" => $to_yb_user,
            "content" => $content
        ];
        return $this->sendRequest("https://openapi.yiban.cn/msg/letter",http_build_query($post_array));
    }

    /**
     * 获取当前用户的基本信息
     * @return bool|string
     */
    function getUserInfo(){
        return json_decode($this->sendRequest("https://openapi.yiban.cn/user/me?access_token=".$this->token));
    }
    static function getUserInfoByYbuid($token,$yb_uid){
        return json_decode(self::sendRequest("https://openapi.yiban.cn/user/other?access_token=".$token."&yb_userid=".$yb_uid));
    }
    /**login
     * api请求工具
     * @param $uri api地址
     * @param string $data post数据，如果是post方法
     * @return bool|string
     */
    static public function sendRequest($uri,$data=""){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Yi OAuth2 v0.1');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        if ($data!=""){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        }
        $response = curl_exec($ch);
        return $response;
    }
}