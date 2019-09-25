<?php
namespace app\chasu\controller;

use app\chasu\common\res;
use app\chasu\facade\login;
use app\chasu\facade\yiban;
use app\chasu\model\Room;
use app\chasu\model\User;
use app\chasu\model\Teacher;
use http\Header;
use think\facade\Config;
use think\facade\Request;

class Index
{
    public function index()
    {
        $yb_uid = yiban::getUid();
        $user_info = yiban::getUserInfo();

        $teacher = Teacher::where([
            'yb_uid' => $yb_uid,
            'isDelete' => 0,
        ])->find();
        if (!$teacher){
            return header("location: /student");
        }
       return view()->assign("user_info",$user_info);
    }
    public function redirect($url){
        header($url);
    }
    public function signUp(){
        return view();
    }
    public function becomeTeacher(){
        return view();
    }
    public function becomeTeacherSub(){
        $post_data = Request::only(["name","phone","extra"],"post");
       if (!$post_data) return 403;
        $post_data["yb_uid"] = yiban::getUid();
        $state = Teacher::create($post_data);
        if ($state){
            return res::success();
        }
    }


    public function Allroom()
    {
        $data = Room::where([
            "isDelete" =>0,
            "prev" => null
        ])->select();
        return json($data);
    }
    public function getRoom($id){
        return Room::where([
            "prev" => $id,
            "isDelete" => 0
        ])->select();
    }
    public function getUser()
    {
        $room_id = Request::post("room") or die("403");
        $user_list = User::where([
            "room" => $room_id,
            "isDelete" => 0
        ])->select();
        return json($user_list);
    }

}
