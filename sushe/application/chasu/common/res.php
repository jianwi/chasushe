<?php
/**
 * Created by PhpStorm
 * User: Dujianjun
 * Date: 2019/9/10
 * Time: 下午8:00
 */

namespace app\chasu\common;


class res
{
    static function success($data=""){
        return json([
            "code" => 200,
            "msg" => "成功",
            "data" => $data
        ]);
    }
    static function fail(){
        return json([
            "code" => 0,
            "msg" => "处理失败"
        ]);
    }
    static function res($data)
    {
        if ($data){
            return self::success();
        }else{
            return self::fail();
        }
    }
}