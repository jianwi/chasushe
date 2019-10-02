<?php
/**
 * Created by PhpStorm
 * User: Dujianjun
 * Date: 2019/9/20
 * Time: 下午10:44
 */

namespace app\chasu\model;


use think\Db;
use think\Model;

class History extends Model
{
    static public function makeLog($type,$msg,$user,$obj,$status=0)
    {
        return self::insert([
            "type" => $type,
            "msg" => $msg,
            "user" => $user,
            "obj" => $obj,
            "status" => $status
        ]);
    }

    static function drawbackRoomCheck($id)
    {
        return Db::table("room_check")->update([
            "isDelete" => 0
        ],[
            "id"=>$id
        ]);
    }
    static function drawbackStudentCheck($id)
    {
        return Db::table("students_check")->update([
            "isDelete" => 0
        ],[
            "id"=>$id
        ]);
    }
}