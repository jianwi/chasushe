<?php
namespace app\chasu\controller;


use app\chasu\common\res;
use app\chasu\facade\yiban;
use app\chasu\model\History;
use app\chasu\model\Room;
use think\Db;
use think\facade\Request;

class Teacher
{
    private  $info;
    public function __construct()
    {
        $yb_uid = yiban::getUid();
        $info = \app\chasu\model\Teacher::where([
            "yb_uid" => $yb_uid,
            "isDelete" => 0,
        ])
            ->where("status",">","0")
            ->find();
            $this->info = $info or die("没有操作权限");

    }
    public function index()
    {
        return view();
    }
    public function checkRoom()
    {
        return view();
    }
    public function checkRoomSub()
    {
        $post_data = Request::only(["room","crime","comment","grade","pic"],"post") or die("403");
        $post_data['teacher_id'] = $this->info['id'];
        return res::res(Db::table("room_check")->insert($post_data));
    }
    public function markUser()
    {
        $post_data = Request::only(["student_id","crime"],"post") or die("403");
        $post_data['teacher_id'] = $this->info['id'];
        return res::res(Db::table("students_check")->insert($post_data));
    }
    public function checkLog()
    {
        return view();
    }
    public function roomCheckLog($p=0)
    {
        $res = Db::table("room_check")
            ->where([
                "room_check.isDelete" => 0,
                "room_check.teacher_id" => $this->info['id'],
                "isDelete" => 0
            ])
            ->limit($p,10)
            ->order("id","desc")
            ->select();
        $res = array_map(function ($i){
        $i["room"] = $this->getRoomInfo($i["room"]);
        return $i;
        },$res);
        return json($res);
    }
    public function roomCheck2Log()
    {
        $id=Request::get("id/d") or die("403");
        $res = Db::table("room_check")
            ->where([
                "room" => $id,
                "room_check.isDelete" => 0,
                "room_check.teacher_id" => $this->info['id'],
                "isDelete" => 0
            ])
//            ->limit($p,10)
            ->order("id","desc")
            ->select();
        $res = array_map(function ($i){
            $i["room"] = $this->getRoomInfo($i["room"]);
            return $i;
        },$res);
        return json($res);
    }
    public function roomCheckInfo($id)
    {
        $res = Db::table("room_check")
            ->where([
                "room_check.isDelete" => 0,
                "room_check.teacher_id" => $this->info['id'],
                "id" => $id
            ])
            ->find();
            $res["room"] = $this->getRoomInfo($res["room"]);
            $res["pic"] = explode(",",$res['pic']);
        return json($res);
    }
    public function modifyCheckInfo()
    {
        $post_data = Request::only(["id","grade","crime","comment","grade"],"post") or die("403");
        $id = intval($post_data['id']);
        unset($post_data['id']);
        $res = Db::table("room_check")->where("id",$id)->update($post_data);
        return res::res($res);
    }
    public function studentCheckLog($p=0)
    {
        $res = Db::table("students_check")
            ->field("students_check.*,user.room,user.name")
            ->where([
                "students_check.isDelete" => 0,
                "students_check.teacher_id" => $this->info['id'],
                "students_check.isDelete" => 0
            ])
            ->Join("user","students_check.student_id=user.id")
            ->withAttr("crime",function ($value){
                $sta = [
                    "1" => "晚归" ,
                    "2" => "夜不归宿"
                ];
                return $sta[$value];
            })
            ->limit($p,10)
            ->order("id","desc")
            ->select();
        $res = array_map(function ($i){
            $i["room"] = $this->getRoomInfo($i["room"]);
            return $i;
        },$res);
        return json($res);
    }
    public function delStudentCheck($id)
    {
        History::makeLog("1","删除学生的违纪信息",$this->info['id'],$id,0);
        return res::res(Db::table("students_check")->where([
            "id"=> $id,
            "teacher_id" => $this->info['id']
        ])->update(["isDelete"=>1]));
    }
    public function delRoomCheck($id){
        History::makeLog("2","删除查宿记录",$this->info['id'],$id,0);
        return res::res(Db::table("room_check")->where([
            "id"=> $id,
            "teacher_id" => $this->info['id']
        ])->update(["isDelete"=>1]));
    }
    public function getRoomInfo($id){
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
    public function upload(){
        $post_file = Request::file("files");
        $info = $post_file->move("./uploads");
        return $info->getSaveName();
    }
}
