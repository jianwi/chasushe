<?php
/**
 * Created by PhpStorm
 * User: Dujianjun
 * Date: 2019/9/8
 * Time: 上午9:56
 */
ini_set("display_errors", "On");
if (isset($_GET['url'])){
    setcookie("url",$_GET['url']);
}
$yiban = require __DIR__ . '/../config/yiban.php';
$APPID = $yiban['appId'];   //在open.yiban.cn管理中心的AppID
$APPSECRET = $yiban['appSecret']; //在open.yiban.cn管理中心的AppSecret
$CALLBACK = $yiban['url'];  //在open.yiban.cn管理中心的oauth2.0回调地址

if (!isset($_GET["verify_request"]) && !isset($_GET["code"])) {
    header("Location: https://openapi.yiban.cn/oauth/authorize?client_id={$APPID}&redirect_uri={$CALLBACK}&display=web");
    die;
}

if (isset($_GET["code"])) {   //用户授权后跳转回来会带上code参数，此处code非access_token，需调用接口转化。
    $getTokenApiUrl = "https://oauth.yiban.cn/token/info?code=" . $_GET['code'] . "&client_id={$APPID}&client_secret={$APPSECRET}&redirect_uri={$CALLBACK}";
    $res = sendRequest($getTokenApiUrl);
    if (!$res) {
        throw new Exception('Get Token Error');
    }
    $userTokenInfo = json_decode($res);
    $access_token = $userTokenInfo["access_token"];
    encryptInfo($_GET['yb_uid'], $access_token);
} else {
    $postStr = pack("H*", $_GET["verify_request"]);
    if (strlen($APPID) == '16') {
        $postInfo = rtrim(openssl_decrypt(pack("H*", $_GET["verify_request"]), 'AES-256-CBC', $APPSECRET, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $APPID));
    } else {
        $postInfo = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $APPSECRET, $postStr, MCRYPT_MODE_CBC, $APPID);
    }
    $postInfo = rtrim($postInfo);
    $postArr = json_decode($postInfo, true);
    if (!$postArr['visit_oauth']) {  //说明该用户未授权需跳转至授权页面
        header("Location: https://openapi.yiban.cn/oauth/authorize?client_id={$APPID}&redirect_uri={$CALLBACK}&display=web");
        die;
    }
    $access_token = $postArr['visit_oauth']['access_token'];
    encryptInfo($_GET['yb_uid'], $access_token);
}

function sendRequest($uri)
{
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
    $response = curl_exec($ch);
    return $response;
}

function encryptInfo($yb_uid, $token)
{
    global $APPSECRET;
    global $APPID;
    $plaintext = json_encode([
        "yb_uid" => $yb_uid,
        "token" => $token,
        "time" => time()
    ]);
    $cipher = openssl_encrypt($plaintext, "aes-128-cbc", md5($APPSECRET), 1, substr(md5($APPID), 0, 16));
    setcookie("tokenInfo", $cipher);
}
if (isset($_COOKIE['url'])){
    setcookie("url","",-100);
    header("Location:http://{$_COOKIE['url']}?tk={$access_token}");
}else{
    header("Location:index.php");
}

