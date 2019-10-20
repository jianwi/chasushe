<?php
namespace app\chasu\model;

use think\Db;
use think\Model;

class User extends Model
{
    static function getUserInfo($id)
    {
        $user_info = User::where([
            "isDelete" => 0,
            "id" => $id
        ])
            ->find();
        $user_info['college_id'] =  $user_info['college'];
        $user_info['class_id'] = $user_info['class'];
        $user_info['college'] = self::getClass($user_info['college']);
        $user_info['class'] = self::getClass($user_info['class']);
        return $user_info;
    }
    static function getClass($id)
    {
        return Db::table("class_info")->where([
            "id" => $id
        ])
            ->value("name");
    }
}