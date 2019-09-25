<?php
/**
 * Created by PhpStorm
 * User: Dujianjun
 * Date: 2019/9/8
 * Time: 下午1:41
 */

namespace app\chasu\model;


use think\Model;

class Room extends Model
{

    static function getRoomInfo($id){
        $fangjian = Room::where("id",$id)->find();
        $louceng = Room::where("id",$fangjian['prev'])->find();
        $danyuan = Room::where("id",$louceng['prev'])->find();
        $gongyu = Room::where("id",$danyuan['prev'])->find();
        return [
            "gongyu" => $gongyu['name'],
            "danyuan" => $danyuan['name'],
            "louceng" => $louceng['name'],
            "fangjian" => $fangjian['name']
        ];
    }
}