<?php
namespace app\chasu\controller;


use app\chasu\common\res;
use app\chasu\facade\yiban;
use app\chasu\model\Feedback;
use app\chasu\model\History;
use app\chasu\model\Room;
use app\chasu\model\User;
use think\Db;
use think\facade\Request;

class Teacher
{
    private  $info;
    private $user;
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
            $this->user = $this->info;

    }
    public function index()
    {
        return view();
    }
    public function checkRoom()
    {
        return view();
    }
    public function getUser()
    {
        $room_id = Request::post("room") or die("403");
        $user_list = User::where([
            "room" => $room_id,
            "isDelete" => 0
        ])->select()->toArray();

        $my_class = db("teacher_class")
            ->where([
                "isDelete" => 0,
                "teacher_id" => $this->info['id']
            ])
            ->column("class");
        $has_my_students = false;
        array_filter($user_list,function ($var)use($my_class, &$has_my_students){
            if (in_array($var['class'],$my_class)){
                $has_my_students = true;
            }
        });
        $res = [
            "has_right" => $has_my_students,
            "user_list" => $user_list
        ];
        return res::res($res);
    }

    /**
     * @return array|\PDOStatement|string|\think\Model|null
     */
    public function getInfo()
    {
        return $this->info;
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
            ->field("students_check.*,user.room,user.name,user.college,user.class")
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
            $i['class'] = User::getClass($i['class']);
            $i['college'] = User::getClass($i['college']);
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
        $xiaoqu = Room::where("id",$gongyu['prev'])->find();
        return [
            "xiaoqu" => $xiaoqu['name'],
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
    public function feedbackLog()
    {
        return view();
    }
    public function getFeedbackList($p=0)
    {
        $res = Feedback::where([
            "feedback.isDelete" => 0,
            "teacher_id" => $this->user['id']
        ])
            ->field("feedback.*,user.name")
            ->join("user","feedback.student_id = user.id")
            ->withAttr("status",function ($status){
                return [
                    0=>"等待处理",
                    -1=>"被驳回",
                    1=> "已处理",
                ][$status];
            })
            ->withAttr("type",function ($status){
                return [
                    1=>"查宿",
                    2=> "学生违纪",
                ][$status];
            })
            ->limit($p,10)
            ->order("id desc")
            ->select();
        return res::res($res);
    }
    public function feedbackDetail()
    {
        $id = Request::get("id/d");
        $res = Feedback::where([
            "feedback.isDelete" => 0,
            "teacher_id" => $this->user['id'],
            "feedback.id" => $id
        ])
            ->field("feedback.*,user.name")
            ->join("user","feedback.student_id = user.id")
            ->withAttr("status",function ($status){
                return [
                    0=>"等待处理",
                    -1=>"被驳回",
                    1=> "已处理",
                ][$status];
            })
            ->withAttr("type",function ($status){
                return [
                    0=>"",
                    1=>"查宿",
                    2=> "学生违纪",
                ][$status];
            })
            ->find();
        return res::res($res);
    }
    public function cancelFeedback()
    {
        $id = Request::post("id/d");
        $reply = Request::post("reply");
        $res = Feedback::update([
            "status" => -1,
            "reply" => $reply
        ],[
            "id" => $id,
            "teacher_id" => $this->user['id']
        ]);
        return res::res($res);
    }
    public function confirmFeedback()
    {
        $id = Request::post("id/d");
        $reply = Request::post("reply");
        $res = Feedback::update([
            "status" => 1,
            "reply" => $reply
        ],[
            "id" => $id,
            "teacher_id" => $this->user['id']
        ]);
        return res::res($res);
    }
    public function fkDealRoom($id="")
    {
        $obj = Feedback::get($id);

        return view()->assign([
            "id"=>$obj['check_id']
        ]);
    }
    public function fkDealStudent($id="")
    {
        $obj = Feedback::get($id);

        return view()->assign([
            "id"=>$obj['check_id']
        ]);
    }
    public function studentCheckInfo($id)
    {
        $res = Db::table("students_check")
            ->field("students_check.*,user.name,user.college,user.major,user.pic,user.room")
            ->where([
                "students_check.isDelete" => 0,
                "students_check.teacher_id" => $this->info['id'],
                "students_check.id" => $id
            ])
            ->withAttr("crime",function ($value){
                $sta = [
                    "1" => "晚归" ,
                    "2" => "夜不归宿"
                ];
                return $sta[$value];
            })
            ->join("user","students_check.student_id=user.id")
            ->find();
        if ($res){
            $res["room"] = $this->getRoomInfo($res["room"]);
        }
        return json($res);
    }
}
