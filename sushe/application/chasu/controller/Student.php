<?php
namespace app\chasu\controller;

use app\chasu\common\res;
use app\chasu\facade\yiban;
use app\chasu\model\User;
use think\Db;
use think\facade\Request;

class Student
{
    private $user;
    function __construct()
    {
        $user = User::where([
            "yb_uid" => yiban::getUid(),
            "isDelete" => 0
        ])->find();
        $this->user = $user;
    }

    public function index()
    {
        $user_info = yiban::getUserInfo();
        if (!$this->isRegister()) return $this->chooseRoom();
        return view()->assign("user_info",$user_info);
    }

    private function isRegister()
    {
        return User::where([
            "isDelete" => 0,
            "yb_uid" => yiban::getUid()
        ])->find();
    }
    public function chooseRoom()
    {

        if ($this->isRegister()) return "你已完善过信息";
        return view();
    }
    public function chooseFormSub()
    {
        $post_file = Request::file("photo") or die("403");
        $info = $post_file->move("./uploads");
        $pic = $info->getSaveName() or die("文件上传失败");
        $post_data = Request::only(["name","college","major","room"],"post") or die("403");
        $post_data['yb_uid']=yiban::getUid();
        $post_data['pic'] = $pic;
        $state = User::create($post_data);
        return res::res($state);
    }
    public function checkLog()
    {
        return view();
    }

    public function studentchecklog($p=0)
    {

        $res = Db::table("students_check")
            ->field("students_check.*,teacher.name as teacher")
            ->where([
                "students_check.isDelete" => 0,
                "students_check.student_id" => $this->user['id'],
            ])
            ->limit($p,10)
            ->join("teacher","students_check.teacher_id = teacher.id")
            ->order("students_check.id","desc")
            ->select();
        return json($res);
    }
    public function roomCheckLog($p=0)
    {
         $res = Db::table("room_check")
             ->field("room_check.*,teacher.name as teacher")
             ->where([
                "room_check.isDelete" => 0,
                "room_check.room" => $this->user['room'],
            ])
             ->limit($p,10)
             ->join("teacher","room_check.teacher_id = teacher.id")
            ->order("id","desc")
            ->select();
        return json($res);
    }
    public function roomcheckinfo($id)
    {
        $res = Db::table("room_check")
            ->where([
                "room_check.isDelete" => 0,
                "id" => $id,
            ])
            ->find();
        $res["pic"] = explode(",",$res['pic']);
        return json($res);
    }
}